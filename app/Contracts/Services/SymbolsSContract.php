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
     * @return mixed
     */
    public function symbolsUnique(): Collection;

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
    public function populateSymbolsTable();
}
