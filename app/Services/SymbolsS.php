<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\Repositories\SymbolsRContract;
use App\Contracts\Services\SymbolsSContract;
use App\Repositories\SymbolsR;
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
     * @param SymbolsR     $symbolsR
     * @param ClosedTradeR $transactionR
     */
    public function __construct(
        SymbolsR $symbolsR,
        ClosedTradeR $transactionR
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
        /** @var ClosedTradeR $repo */
        $repo = $this->getTransactionR();
        $allSymbols = $repo->symbolsUnique();

        /** @var SymbolsR $repo */
        $repo = $this->getSymbolsR();
        $symbolE = $repo->getEntity();

        $collection = $repo->getCollection();

        foreach ($allSymbols as $transactionE) {
            $collection->push($symbolE->translateByEntity($transactionE));
        }

        return $collection;
    }
}
