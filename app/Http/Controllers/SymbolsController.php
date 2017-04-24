<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Contracts\Services\SymbolsSContract;
use Illuminate\Support\Facades\App;

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

    /*
     *  testing only method.
     */
    public function testPopulateSymbolsTable()
    {
        if (App::environment('local')) {
            $this->getSymbolService()->populateSymbolsTable();

            return 'success';
        }

        return $this;
    }

    /*
     *  testing only method.
     */
    public function testSymbolsUnique()
    {
        if (App::environment('local')) {
            $this->getSymbolService()->symbolsUnique();

            return 'success';
        }

        return $this;
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
