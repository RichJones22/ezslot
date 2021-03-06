<?php

declare(strict_types=1);

namespace App\Services;

use App\Entities\TransactionAggregateE;
use App\Repositories\SymbolsE;
use App\Repositories\SymbolsR;
use App\Repositories\TransactionAggregateR;
use ArrayObject;
use DB;
use Illuminate\Support\Collection;
use Premise\Utilities\DateTime\CurrentDateTime;

/**
 * Class TransactionAggregateS.
 */
class TransactionAggregateS
{
    /**
     * @var TransactionAggregateR
     */
    private $aggregateR;
    /**
     * @var SymbolsS
     */
    private $symbolS;
    /**
     * @var CloseTradeS
     */
    private $closeTradeS;

    /**
     * TransactionAggregateS constructor.
     *
     * @param TransactionAggregateR $aggregateR
     * @param SymbolsS              $symbolService
     * @param CloseTradeS           $closeTradeS
     */
    public function __construct(
        TransactionAggregateR $aggregateR,
        SymbolsS $symbolService,
        CloseTradeS $closeTradeS
    ) {
        $this->setAggregateR($aggregateR);
        $this->setSymbolS($symbolService);
        $this->setCloseTradeS($closeTradeS);
    }

    /**
     * @param $symbol
     *
     * @return Collection
     */
    public function getBySymbol($symbol): Collection
    {
        // wrap io in transaction
        $transactions = DB::transaction(function () use ($symbol) {
            return $this->getBySymbolTransaction($symbol);
        });

        return $transactions;
    }

    /**
     * @return Collection
     */
    public function getAllPutTrades(): Collection
    {
        $monthsBack = CurrentDateTime::new()->daysBack(720);

        $result = $this->getNewCollection();

        $allSymbols = $this
            ->symbolS
            ->symbolsUnique()
            ->all();

        /** @var SymbolsE $symbol */
        foreach ($allSymbols as $symbol) {
            $transactions = $this
                ->getBySymbolTransaction($symbol->getUnderlierSymbol());

            $tmp = $transactions->filter(function (TransactionAggregateE $x) {
                return $x->getTradeClosed();
            });

            $result->push($tmp->all());
        }

        // flatten into an array; also removes empty $result
        $tmp = [];
        $results = $result->all();
        foreach ($results as $result) {
            foreach ($result as $value) {
                $tmp[] = $value;
            }
        }

        /** @var Collection $tmp */
        $tmp = new Collection($tmp);
        $tmp = $tmp->sort()->reverse();
        $tmp = $tmp->filter(function (TransactionAggregateE $x) use ($monthsBack) {
            return $x->getCloseDate() > $monthsBack;
        });

        return $tmp;
    }

    /**
     * @return TransactionAggregateR
     */
    public function getAggregateR(): TransactionAggregateR
    {
        return $this->aggregateR;
    }

    /**
     * @param TransactionAggregateR $aggregateR
     *
     * @return TransactionAggregateS
     */
    public function setAggregateR(TransactionAggregateR $aggregateR): TransactionAggregateS
    {
        $this->aggregateR = $aggregateR;

        return $this;
    }

    /**
     * @return SymbolsS
     */
    public function getSymbolS(): SymbolsS
    {
        return $this->symbolS;
    }

    /**
     * @param SymbolsS $symbolS
     *
     * @return TransactionAggregateS
     */
    public function setSymbolS(SymbolsS $symbolS): TransactionAggregateS
    {
        $this->symbolS = $symbolS;

        return $this;
    }

    /**
     * @return CloseTradeS
     */
    public function getCloseTradeS(): CloseTradeS
    {
        return $this->closeTradeS;
    }

    /**
     * @param CloseTradeS $closeTradeS
     *
     * @return TransactionAggregateS
     */
    public function setCloseTradeS(CloseTradeS $closeTradeS): TransactionAggregateS
    {
        $this->closeTradeS = $closeTradeS;

        return $this;
    }

    /**
     * @param Collection $transactions
     *
     * @return Collection
     */
    protected function findRemoveSingleBuyItem(Collection $transactions): Collection
    {
        // sort by expiration, which pulls out single buys, that can exist between BUY and SELL close dates
        $transactions = $transactions->sort(function (TransactionAggregateE $a, TransactionAggregateE $b) {
            if ($a->getExpiration() === $b->getExpiration()) {
                return 0;
            }

            return ($a->getExpiration() < $b->getExpiration()) ? -1 : 1;
        });

        $transactions = $this->removeSingleBuys($transactions);

        return $transactions;
    }

    /**
     * @param Collection $transactions
     *
     * @return Collection
     */
    protected function removeSingleBuys(Collection $transactions): Collection
    {
        /** @var TransactionAggregateE $transaction */
        foreach ($transactions as $transaction) {
            if ($transaction->getOptionSide() === 'BUY') {
                $counts = $this->aggregateR->findSingleBuys($transaction);

                foreach ($counts as $count) {
                    if ($count->count === 1) {
                        // pull all other transactions except the one we found, which essentially removes it.
                        $transactions = $transactions->filter(function (TransactionAggregateE $x) use ($transaction) {
                            if ($x->getTransactionId() !== $transaction->getTransactionId()) {
                                return $x;
                            }

                            return false;
                        });
                    }
                }
            }
        }

        return $transactions;
    }

    /**
     * groups partial fills as one aggregate transaction; much easier to read this way.
     *
     * @param Collection $transactions
     *
     * @return Collection
     */
    protected function consolidateTransactions(Collection $transactions): Collection
    {
        $transactions = new ArrayObject($transactions->all());

        $iterator = $transactions->getIterator();

        while ($iterator->valid()) {
            $counts = $this->aggregateR->findGroups($iterator->current());

            foreach ($counts as $count) {
                // check if we have a group to consolidate
                if ($count->count > 1) {
                    // consolidate the group
                    $pos = $iterator->key();

                    if ($pos <= $iterator->count()) {
                        list($transactions, $advance) = $this->consolidateGroup(Collect($transactions), $iterator->current());

                        if ( ! ($pos + $advance >= $iterator->count())) {
                            $iterator->seek($pos + $advance);
                        }
                    }

                    break;
                }
            }

            $iterator->next();
        }

        return Collect($transactions);
    }

    /**
     * collection manipulation:
     * - squash the group down to a single element
     * - sum the quantity and amount values
     * - place squashed element back on collection
     * - sort the collection.
     *
     * @param Collection $transactions
     * @param $transaction
     *
     * @return array
     */
    protected function consolidateGroup(Collection $transactions, TransactionAggregateE $transaction): array
    {
        // pull out the group.

        // check if we have an expired option
        if ($transaction->getTradeType() === 'Option Expiration') {
            $toSum = $transactions->filter(function (TransactionAggregateE $x) use ($transaction) {
                if ($x->getSymbol() === $transaction->getSymbol() &&
                    $x->getUnderlierSymbol() === $transaction->getUnderlierSymbol() &&
                    $x->getOptionSide() === $transaction->getOptionSide()
                ) {
                    return $x;
                }

                return false;
            });
        } else {
            $toSum = $transactions->filter(function (TransactionAggregateE $x) use ($transaction) {
                if ($x->getCloseDate() === $transaction->getCloseDate() &&
                    $x->getUnderlierSymbol() === $transaction->getUnderlierSymbol() &&
                    $x->getOptionSide() === $transaction->getOptionSide()
                ) {
                    return $x;
                }

                return false;
            });
        }

        // number to advance for the calling iterator
        $iteratorCount = $toSum->count();

        // sum the amounts
        $sumAmount = $toSum->reduce(function ($carry, TransactionAggregateE $item) {
            return $carry += $item->getAmount();
        });

        // sum the quantities
        $sumQuantity = $toSum->reduce(function ($carry, TransactionAggregateE $item) {
            return $carry += $item->getOptionQuantity();
        });

        // create the summed element
        /** @var TransactionAggregateE $toAddBack */
        $toAddBack = $toSum->first();
        $toAddBack->setAmount($sumAmount);
        $toAddBack->setOptionQuantity($sumQuantity);

        // remove the group from the array
        if ($transaction->getTradeType() === 'Option Expiration') {
            $newArray = $transactions->filter(function (TransactionAggregateE $x) use ($transaction) {
                if ($x->getSymbol() !== $transaction->getSymbol() ||
                    $x->getUnderlierSymbol() !== $transaction->getUnderlierSymbol() ||
                    $x->getOptionSide() !== $transaction->getOptionSide()
                ) {
                    return $x;
                }

                return false;
            });
        } else {
            $newArray = $transactions->filter(function (TransactionAggregateE $x) use ($transaction) {
                if ($x->getCloseDate() !== $transaction->getCloseDate() ||
                    $x->getUnderlierSymbol() !== $transaction->getUnderlierSymbol() ||
                    $x->getOptionSide() !== $transaction->getOptionSide()
                ) {
                    return $x;
                }

                return false;
            });
        }

        // get array position
        $pos = $toSum->keys()->first();

        // add the summed element back to the array
        $newArray->put($pos, $toAddBack);

        // sort the array.
        $transactions = $newArray->all();
        ksort($transactions);

        return [$transactions, $iteratorCount];
    }

    /**
     * @param Collection $transactions
     *
     * @return Collection
     */
    protected function determineTradeProfits(Collection $transactions): Collection
    {
        $tradeProfit = 0;

        /** @var CloseTradeS $service */
        $closeTradeS = $this->getCloseTradeS();
        /** @var Collection $closedTradesColl */
        $closedTradesColl = $closeTradeS->getClosedTradeR()->getCollection();
        $closedTradesColl = new $closedTradesColl();

        /** @var TransactionAggregateE $transaction */
        foreach ($transactions as $transaction) {
            $tradeProfit += $transaction->getAmount();
            $transaction->setTradeClosed(false);

            if ($this->didTradeEnd($transaction)) {
                $this->setTradeCloseValue($transaction);
                $closedTradesColl->push($transaction);

                $closeTradeS->persist($closedTradesColl);

                $transaction->setProfits($tradeProfit);
                $tradeProfit = 0;
                $closedTradesColl = new $closedTradesColl();
            } else {
                $transaction->setProfits(0);
                $closedTradesColl->push($transaction);
            }
        }

        return $transactions;
    }

    /**
     * @param TransactionAggregateE $aggregateE
     *
     * @return bool
     */
    protected function didTradeEnd(TransactionAggregateE $aggregateE): bool
    {
        // determine if trade has ended.
        if ($aggregateE->getOptionSide() === 'BUY') {
            $counts = $this->aggregateR->findSellSideTrades($aggregateE);

            foreach ($counts as $count) {
                if ($count->count === 0) {
                    return true;
                }
            }

            //  TODO: below has to do with being assigned... handle this separately...
//        } elseif ($aggregateE->getOptionSide() === 'SELL') {
//            if ($count !== $i) {
//                $counts = $this->aggregateR->findTrades($aggregateE);
//
//                foreach ($counts as $count) {
//                    if (CurrentDateTime::new()->currentDate() > $aggregateE->getExpiration()) {
//                        if ($count->count === 1) {
//                            return true;
//                        }
//                    }
//                }
//            }
        }

        return false;
    }

    /**
     * @param $symbol
     *
     * @return Collection
     */
    protected function getBySymbolTransaction($symbol): Collection
    {
        // get all trades by symbol
        $CollectionAggregateE = $this
            ->aggregateR
            ->getAllOptionsHouseTransactionsBySymbol($symbol);

        // cull single buy options; this technique is for selling and rolling sold options
        $transactions = $this->findRemoveSingleBuyItem($CollectionAggregateE);

        // consolidate transactions
        $transactions = $this->consolidateTransactions($transactions);

        // calculate trade breaks and profits per trade
        /* @var TransactionAggregateE $transaction */
        $this->determineTradeProfits($transactions);

        return $transactions;
    }

    /**
     * @param TransactionAggregateE $transaction
     */
    protected function setTradeCloseValue(TransactionAggregateE $transaction)
    {
        if ($transaction->getCloseDate() < CurrentDateTime::new()->currentDate()) {
            $transaction->setTradeClosed(true);
        } else {
            $transaction->setTradeClosed(false);
        }
    }

    /**
     * derive collection off of symbols repo.
     *
     * @return Collection
     */
    private function getNewCollection(): Collection
    {
        /** @var SymbolsR $collection */
        $collection = $this->symbolS->getSymbolsR();

        $collection = $collection->getCollection();

        return new $collection();
    }
}
