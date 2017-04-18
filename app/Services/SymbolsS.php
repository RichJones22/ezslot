<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\Repositories\SymbolsRContract;
use App\Contracts\Services\SymbolsSContract;
use App\Repositories\SymbolsE;
use App\Repositories\SymbolsR;
use App\SymbolsM;
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
     * @var SymbolsM
     */
    private $symbolsM;

    /**
     * SymbolsS constructor.
     *
     * @param SymbolsR $symbolsR
     * @param SymbolsM $symbolsM
     */
    public function __construct(
        SymbolsR $symbolsR,
        SymbolsM $symbolsM // TODO:  SymbolsR should not be using OptionsHouseTransactionM a a model.
                           // TODO:  We need to finish the TransactionsR.  This would would then be used by this
                           // TODO:  service... Need to to this next!
    ) {
        $this->setSymbolsR($symbolsR);
        $this->setSymbolsM($symbolsM);
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
        /** @var SymbolsR $repo */
        $repo = $this->getSymbolsR();
        $allSymbols = $repo->symbolsUnique();

        // switch model to symbols model.
        $repo->setModel($this->getSymbolsM());

        /** @var SymbolsE $symbol */
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
     * @return SymbolsM
     */
    public function getSymbolsM(): SymbolsM
    {
        return $this->symbolsM;
    }

    /**
     * @param SymbolsM $symbolsM
     *
     * @return SymbolsS
     */
    public function setSymbolsM(SymbolsM $symbolsM): SymbolsS
    {
        $this->symbolsM = $symbolsM;

        return $this;
    }
}
