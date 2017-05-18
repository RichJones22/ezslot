<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\Repositories\SymbolsRContract;
use App\Contracts\Services\SymbolsSContract;
use App\Entities\TransactionAggregateE;
use App\Repositories\SymbolsE;
use App\Repositories\SymbolsR;
use App\Repositories\TransactionAggregateR;
use Illuminate\Support\Collection;

/**
 * Class SymbolService.
 */
class SymbolsS implements SymbolsSContract
{
    /**
     * @var SymbolsRContract
     */
    private $symbolsR;

    /**
     * @var
     */
    private $transactionR;

    /**
     * SymbolsS constructor.
     *
     * @param SymbolsR              $symbolsR
     * @param TransactionAggregateR $transactionR
     */
    public function __construct(
        SymbolsR $symbolsR,
        TransactionAggregateR $transactionR
    ) {
        $this->setSymbolsR($symbolsR);
        $this->setTransactionR($transactionR);
    }

    /**
     * @return Collection
     */
    public function symbolsUnique(): Collection
    {
        // if the symbols table contains data, return it.
        if (count($allSymbols = $this->doesSymbolsDataExists())) {
            return $allSymbols;
        }

        // symbols table does not contain data; get symbols data from the options_house_transaction table.
        return $this->getSymbolsDataFromOptionHouseTransactionTable();
    }

    /**
     * Symbols table persistence.
     */
    public function populateSymbolsTable()
    {
        $allSymbols = $this->symbolsUnique();

        /** @var SymbolsR $repo */
        $repo = $this->getSymbolsR();

        foreach ($allSymbols as $symbol) {
            if ( ! $repo->rowExistsByUnderlierSymbol($symbol)) {
                $repo->persistEntity($symbol);
            }
        }
    }

    /**
     * @return SymbolsRContract
     */
    public function getSymbolsR(): SymbolsRContract
    {
        return $this->symbolsR;
    }

    /**
     * @param SymbolsRContract $symbolsR
     *
     * @return SymbolsS
     */
    public function setSymbolsR(SymbolsRContract $symbolsR): SymbolsS
    {
        $this->symbolsR = $symbolsR;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTransactionR()
    {
        return $this->transactionR;
    }

    /**
     * @param mixed $transactionR
     *
     * @return SymbolsS
     */
    public function setTransactionR($transactionR)
    {
        $this->transactionR = $transactionR;

        return $this;
    }

    /**
     * @return Collection
     */
    protected function doesSymbolsDataExists(): Collection
    {
        /** @var SymbolsR $repo */
        $repo = $this->getSymbolsR();

        return $repo->symbolsUnique();
    }

    /**
     * @return Collection
     */
    protected function getSymbolsDataFromOptionHouseTransactionTable(): Collection
    {
        $repo = $this->getTransactionR();
        $allSymbols = $repo->symbolsUnique();

        /** @var SymbolsR $repo */
        $repo = $this->getSymbolsR();

        $collection = $repo->getCollection();

        /** @var TransactionAggregateE $transactionE */
        foreach ($allSymbols as $transactionE) {
            /** @var SymbolsE $symbolE */
            $symbolE = $repo->getEntity();
            $symbolE = new $symbolE();

            $symbolE->setUnderlierSymbol($transactionE->getUnderlierSymbol());
            $symbolE->setSecurityDescription($transactionE->getSecurityDescription());

            $collection->push($symbolE);
        }

        return $collection;
    }
}
