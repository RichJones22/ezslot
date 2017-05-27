<?php

declare(strict_types=1);

namespace App\Services;

use App\Entities\ClosedTradeE;
use App\Entities\TransactionAggregateE;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Class CloseTradeS.
 */
class CloseTradeS
{
    /**
     * @var ClosedTradeR
     */
    private $closedTradeR;

    /**
     * CloseTradeS constructor.
     *
     * @param ClosedTradeR $closedTradeR
     */
    public function __construct(ClosedTradeR $closedTradeR)
    {
        $this->setClosedTradeR($closedTradeR);
    }

    /**
     * @param Collection $collection
     *
     * @return $this
     */
    public function persist(Collection $collection)
    {
        // if record exist; early exist.
        if ($this->doesClosedTradeExists($collection)) {
            return $this;
        }

        DB::Transaction(function () use ($collection) {
            // build details array
            $details = $this->buildTradeDetails($collection);

            /** @var ClosedTradeE $closedTradeE */
            $closedTradeE = $this->getCloseTradeEntity();

            // populate and persist the closedTradeE entity.
            $this->populateClosedTradeE($closedTradeE, $collection, $details);
            $this->getClosedTradeR()->persistEntity($closedTradeE);
        });

        return $this;
    }

    /**
     * @return \App\Entities\BaseEntity|string
     */
    public function getCloseTradeEntity()
    {
        $closedTradeE = $this->getClosedTradeR()->getEntity();
        $closedTradeE = new $closedTradeE();

        return $closedTradeE;
    }

    /**
     * @param Collection $collection
     *
     * @return int
     */
    public function doesClosedTradeExists(Collection $collection)
    {
        // get the max transaction
        $transactionAggregateE = $collection->max(function (TransactionAggregateE $x) {
            return $x;
        });

        $closeDate = $transactionAggregateE->getCloseDate();
        $underlier_symbol = $transactionAggregateE->getUnderlierSymbol();

        $results = $this
            ->getClosedTradeR()
            ->getClosedTradeByDateAndSymbol($closeDate, $underlier_symbol)
            ->all();

        return count($results);
    }

    /**
     * @return ClosedTradeR
     */
    public function getClosedTradeR(): ClosedTradeR
    {
        return $this->closedTradeR;
    }

    /**
     * @param ClosedTradeR $closedTradeR
     *
     * @return CloseTradeS
     */
    public function setClosedTradeR(ClosedTradeR $closedTradeR): CloseTradeS
    {
        $this->closedTradeR = $closedTradeR;

        return $this;
    }

    /**
     * @param $collection
     *
     * @return array
     */
    public function buildTradeDetails(Collection $collection): array
    {
        $details = [];

        $collectionCount = count($collection);

        for ($i = 0; $i < $collectionCount; ++$i) {
            /** @var TransactionAggregateE $transactionAggregateE */
            $transactionAggregateE = $collection[$i];

            if ($i === 0) {
                $profits = $collection[$i]->getAmount();
                $transactionAggregateE->setProfits($profits);
            } else {
                if ($collection[$i]->getOptionSide() === 'SELL') {
                    if ($collection[$i - 1]->getOptionSide() === 'BUY') {
                        $profits = $collection[$i]->getAmount() + $collection[$i - 1]->getAmount();
                        $transactionAggregateE->setProfits($profits);
                    }
                }
            }

            // prevent total profits from being counted twice
            if ($i === $collectionCount - 1) {
                if ($collection[$i]->getOptionSide() === 'BUY') {
                    $transactionAggregateE->setProfits($collection[$i]->getAmount());
                }
            }

            $details[] = $this->buildDetailsArray($transactionAggregateE);
        }

        return $details;
    }

    /**
     * @param ClosedTradeE $closedTradeE
     * @param Collection   $collection
     * @param array        $details
     */
    protected function populateClosedTradeE(ClosedTradeE $closedTradeE, Collection $collection, array $details)
    {
        // get the max transaction
        $transactionAggregateE = $collection->max(function (TransactionAggregateE $x) {
            return $x;
        });

        $closedTradeE->setCloseDate($transactionAggregateE->getCloseDate());
        $closedTradeE->setUnderlierSymbol($transactionAggregateE->getUnderlierSymbol());

        $closedTradeE->setTradeDetails(json_encode($details));
    }

    /**
     * @param TransactionAggregateE $transactionAggregateE
     *
     * @return array
     */
    protected function buildDetailsArray(TransactionAggregateE $transactionAggregateE)
    {
        return [
            'close_date' => $transactionAggregateE->getCloseDate(),
            'underlier_symbol' => $transactionAggregateE->getUnderlierSymbol(),
            'security_description' => $transactionAggregateE->getSecurityDescription(),
            'position_state' => $transactionAggregateE->getPositionState(),
            'option_side' => $transactionAggregateE->getOptionSide(),
            'option_type' => $transactionAggregateE->getOptionType(),
            'option_quantity' => $transactionAggregateE->getOptionQuantity(),
            'strike_price' => $transactionAggregateE->getStrikePrice(),
            'expiration' => $transactionAggregateE->getExpiration(),
            'amount' => $transactionAggregateE->getAmount(),
            'profits' => $transactionAggregateE->getProfits(),
            'symbol' => $transactionAggregateE->getSymbol(),
            'transaction_id' => $transactionAggregateE->getTransactionId(),
        ];
    }
}
