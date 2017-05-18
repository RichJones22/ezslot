<?php

declare(strict_types=1);

namespace App\Contracts\Services;

use App\Contracts\Repositories\SymbolsRContract;
use App\Services\SymbolsS;
use Illuminate\Support\Collection;

/**
 * Class SymbolService.
 */
interface SymbolsSContract
{
    /**
     * @return Collection
     */
    public function symbolsUnique(): Collection;

    /**
     * Symbols table persistence.
     */
    public function populateSymbolsTable();

    /**
     * @return SymbolsRContract
     */
    public function getSymbolsR(): SymbolsRContract;

    /**
     * @param SymbolsRContract $symbolsR
     *
     * @return SymbolsS
     */
    public function setSymbolsR(SymbolsRContract $symbolsR): SymbolsS;

    /**
     * @return mixed
     */
    public function getTransactionR();

    /**
     * @param mixed $transactionR
     *
     * @return SymbolsS
     */
    public function setTransactionR($transactionR);
}
