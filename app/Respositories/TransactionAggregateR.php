<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\TransactionAggregateE;
use App\Models\OptionsHouseTransactionM;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * Class TransactionAggregateR.
 */
class TransactionAggregateR
{
    /**
     * @var array
     */
    private $tradeWhere = ['Trade', 'Option Expiration'];

    private $optionType = ['PUT'];

    private $securityType = ['Option'];

    /**
     * @var string
     */
    private $fromDate = '1900-01-01';

    /**
     * @var TransactionAggregateE
     */
    private $TransactionAggregateE;
    /**
     * @var Collection
     */
    private $collection;

    /**
     * @var Model
     */
    private $model;

    /**
     * TransactionAggregateR constructor.
     *
     * @param OptionsHouseTransactionM $optionsHouseTransaction
     * @param Collection               $collection
     * @param TransactionAggregateE    $aggregateE
     */
    public function __construct(
        OptionsHouseTransactionM $optionsHouseTransaction,
        Collection $collection,
        TransactionAggregateE $aggregateE
    ) {
        $this->model = $optionsHouseTransaction;
        $this->collection = $collection;
        $this->TransactionAggregateE = $aggregateE;
    }

    /**
     * @param $symbol
     *
     * @return Collection
     */
    public function getAllOptionsHouseTransactionsBySymbol($symbol): Collection
    {
        /** @var Collection<StdClass> $transactions */
        $transactions = DB::table('options_house_transaction')
            ->select(
                'close_date',
                'underlier_symbol',
                'security_description',
                'position_state',
                'option_side',
                'option_type',
                'option_quantity',
                'strike_price',
                'expiration',
                'amount',
                'symbol',
                'trade_type',
                'transaction_id')
            ->whereIn('trade_type', $this->tradeWhere)
            ->whereIn('option_type', $this->optionType)
            ->where('underlier_symbol', $symbol)
            ->where('security_type', $this->securityType)
            ->where('close_date', '>', $this->fromDate)
            ->orderBy('close_date', 'asc')
            ->orderBy('expiration', 'asc')
            ->orderBy('option_side', 'desc')
            ->get();

        // derive TransactionAggregateE collection
        return $this->hydrate($transactions);
    }

    /**
     * persist entity to db.
     *
     * @param Collection $transactions<TransactionAggregateE>
     */
    public function save(Collection $transactions)
    {
        foreach ($transactions as $transaction) {
            /** @var Model $model */
            $model = new $this->model();

            foreach ($transaction as $key => $value) {
                $model->setAttribute($key, $value);
            }

            $model->save();
        }
    }

    /**
     * @param TransactionAggregateE $aggregateE
     *
     * @return Collection
     */
    public function findSingleBuys(TransactionAggregateE $aggregateE): Collection
    {
        $counts = DB::table('options_house_transaction')
            ->select(DB::raw('count(*) as count'))
            ->whereIn('trade_type', $this->tradeWhere)
            ->whereIn('option_type', $this->optionType)
            ->where('expiration', $aggregateE->getExpiration())
            ->where('underlier_symbol', $aggregateE->getUnderlierSymbol())
            ->where('security_type', 'OPTION')
            ->get();

        return $counts;
    }

    /**
     * @param TransactionAggregateE $aggregateE
     *
     * @return Collection
     */
    public function findGroups(TransactionAggregateE $aggregateE): Collection
    {
        if ($aggregateE->getTradeType() === 'Option Expiration') {
            $counts = DB::table('options_house_transaction')
                ->select(DB::raw('count(*) as count'))
                ->whereIn('option_type', $this->optionType)
                ->whereIn('trade_type', $this->tradeWhere)
                ->where('symbol', $aggregateE->getSymbol())
                ->where('option_side', $aggregateE->getOptionSide())
                ->where('position_state', $aggregateE->getPositionState())
                ->where('security_type', $this->securityType)
                ->get();
        } else {
            $counts = DB::table('options_house_transaction')
                ->select(DB::raw('count(*) as count'))
                ->whereIn('option_type', $this->optionType)
                ->where('expiration', $aggregateE->getExpiration())
                ->where('underlier_symbol', $aggregateE->getUnderlierSymbol())
                ->where('option_side', $aggregateE->getOptionSide())
                ->where('security_type', 'OPTION')
                ->get();
        }

        return $counts;
    }

    /**
     * @param TransactionAggregateE $aggregateE
     *
     * @return Collection
     */
    public function findSellSideTrades(TransactionAggregateE $aggregateE): Collection
    {
        $counts = DB::table('options_house_transaction')
            ->select(DB::raw('count(*) as count'))
            ->whereIn('option_type', $this->optionType)
            ->where('close_date', $aggregateE->getCloseDate())
            ->where('underlier_symbol', $aggregateE->getUnderlierSymbol())
            ->where('option_side', 'SELL')
            ->where('security_type', 'OPTION')
            ->whereIn('trade_type', $this->tradeWhere)
            ->get();

        return $counts;
    }

    /**
     * @param TransactionAggregateE $aggregateE
     *
     * @return Collection
     */
    public function findTrades(TransactionAggregateE $aggregateE): Collection
    {
        $counts = DB::table('options_house_transaction')
            ->select(DB::raw('count(*) as count'))
            ->whereIn('option_type', $this->optionType)
            ->where('symbol', $aggregateE->getSymbol())
            ->where('security_type', 'OPTION')
            ->whereIn('trade_type', $this->tradeWhere)
            ->get();

        return $counts;
    }

    /**
     * @return Collection
     */
    public function symbolsUnique(): Collection
    {
        $collection = DB::table('options_house_transaction')
            ->select('underlier_symbol', 'security_description')
            ->groupBy('underlier_symbol', 'security_description')
            ->whereIn('option_type', $this->optionType)
            ->where('underlier_symbol', '<>', '')
            ->where('close_date', '>', $this->fromDate)
            ->get()
        ;

        // remove duplicates...
        $collection = $collection->unique('underlier_symbol');

        return $this->hydrate($collection);
    }

    /**
     * @param string|null $fromDate
     *
     * @return $this
     */
    public function setFromDate(string $fromDate = null)
    {
        if ( ! empty($fromDate)) {
            $this->fromDate = $fromDate;
        }

        return $this;
    }

    /**
     * populate the entity with model data.
     *
     * @param Collection $transactions<Model StdClass>
     *
     * @return Collection<TransactionAggregateE>
     */
    protected function hydrate(Collection $transactions): Collection
    {
        /** @var Collection $transactionAggregateCollection */
        $transactionAggregateCollection = new $this->collection();

        foreach ($transactions as $transaction) {
            /** @var TransactionAggregateE $transactionAggregate */
            $transactionAggregate = new $this->TransactionAggregateE();

            foreach ($transaction as $key => $value) {
                $method = 'set'.ucfirst(Str::camel($key));
                $transactionAggregate->$method($value);
            }

            $transactionAggregateCollection->push($transactionAggregate);
        }

        return $transactionAggregateCollection;
    }
}
