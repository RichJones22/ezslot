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
        $this->symbolService = $symbolsS;
    }

    public function testSymbols()
    {
        $helpMe = null;
    }
}
