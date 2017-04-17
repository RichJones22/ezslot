<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Contracts\Services\SymbolsSContract;

/**
 * Class SymbolsController.
 */
class SymbolsController extends Controller
{
    private $symbolService;

    /**
     * SymbolsController constructor.
     *
     * @param SymbolsSContract $symbolsS
     */
    public function __construct(SymbolsSContract $symbolsS)
    {
        $this->setSymbolService($symbolsS);
    }

    public function testSymbols()
    {
        $this->getSymbolService()->populateSymbolsTable();
    }

    /**
     * @return SymbolsSContract
     */
    public function getSymbolService(): SymbolsSContract
    {
        return $this->symbolService;
    }

    /**
     * @param SymbolsSContract $symbolService
     *
     * @return SymbolsController
     */
    public function setSymbolService(SymbolsSContract $symbolService): SymbolsController
    {
        $this->symbolService = $symbolService;

        return $this;
    }
}
