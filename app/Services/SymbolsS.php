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
     * SymbolsS constructor.
     *
     * @param SymbolsR $symbolsR
     */
    public function __construct(
        SymbolsR $symbolsR
    ) {
        $this->setSymbolsR($symbolsR);
    }

    /**
     * @return Collection
     */
    public function symbolsUnique(): Collection
    {
        /** @var SymbolsR $repo */
        $repo = $this->getSymbolsR();

        return $repo->symbolsUnique();
    }

    public function populateSymbolsTable()
    {
        $helpMe = null;
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
}
