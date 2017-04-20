<?php

declare(strict_types=1);

namespace Tests\Unit\ServiceTests;

use App\Entities\TransactionE;
use App\Models\OptionsHouseTransactionM;
use App\Models\SymbolsM;
use App\Repositories\SymbolsE;
use App\Repositories\SymbolsR;
use App\Services\SymbolsS;
use App\Services\TransactionR;
use Illuminate\Support\Collection;
use Tests\TestCase;

class SymbolsServiceTest extends TestCase
{
    /** @var SymbolsS */
    private $symbolsS;
    /** @var  TransactionR */
    private $transactionR;

    public function setUp()
    {
        parent::setUp();

        $this->symbolsS = new SymbolsS(
            new SymbolsR(
                new SymbolsE(),
                new SymbolsM(),
                new Collection()
            ),
            new TransactionR(
                new TransactionE(),
                new OptionsHouseTransactionM(),
                new Collection()
            )
        );

        $this->transactionR = new TransactionR(
            new TransactionE(),
            new OptionsHouseTransactionM(),
            new Collection()
        );
    }

    /**
     * A basic test example.
     */
    public function testSymbolsUnique()
    {
        $allSymbols = $this->symbolsS->symbolsUnique();

        $transSymbols = $this->transactionR->symbolsUnique();

        $this->assertEquals(count($allSymbols), count($transSymbols));
    }
}
