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
use Carbon\Carbon;
use DB;
use Illuminate\Support\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;


/**
 * Class SymbolsServiceTest
 * @package Tests\Unit\ServiceTests
 */
class SymbolsServiceTest extends TestCase
{
//    use DatabaseTransactions;  // could not get this to work?

    /** @var SymbolsS */
    private $symbolsS;
    /** @var TransactionR */
    private $transactionR;

    /**
     *
     */
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

    public function tearDown()
    {
        parent::tearDown();

    }

    /**
     *  data may or may not be contained in the symbols table
     */
    public function testSymbolsUnique()
    {
        $allSymbols = $this->symbolsS->symbolsUnique();

        $transSymbols = $this->transactionR->symbolsUnique();

        $this->assertSame(count($allSymbols), count($transSymbols));
    }

    /**
     * - get unique symbols from the options_house_transactions table.
     * - populate the symbols table.
     * - delete records from the options_house_transactions table.
     * - perform a symbolsS->symbolsUnique(), which should pick up symbols from the symbols table.
     * - compare the counts
     */
    public function testPopulateSymbolsTable()
    {
        $tomorrow = Carbon::now()->addDays(1);

        $transSymbols = $this->transactionR->symbolsUnique();

        /** @var SymbolsR $repoS */
        $repoS = $this->symbolsS->getSymbolsR();
        $repoS->getModel()
            ->newQuery()
            ->where('created_at', '<=', $tomorrow)
            ->delete();

        $this->symbolsS->populateSymbolsTable();

        $allSymbols = $this->symbolsS->symbolsUnique();

        $this->assertSame(count($transSymbols), count($allSymbols));
    }
}
