<?php

declare(strict_types=1);

namespace Tests\Unit\ServiceTests;

use App\database\fixtures\SeedFixtureOptionsHouseTransaction;
use App\Entities\TransactionAggregateE;
use App\Models\OptionsHouseTransactionM;
use App\Models\SymbolsM;
use App\Repositories\SymbolsE;
use App\Repositories\SymbolsR;
use App\Repositories\TransactionAggregateR;
use App\Services\SymbolsS;
use Artisan;
use Carbon\Carbon;
use DB;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Collection;
use Tests\TestCase;

/**
 * Class SymbolsServiceTest.
 */
class SymbolsServiceTest extends TestCase
{
    use DatabaseMigrations;

    /** @var SymbolsS */
    private $symbolsS;
    /** @var TransactionAggregateR */
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
            new TransactionAggregateR(
                new OptionsHouseTransactionM(),
                new Collection(),
                new TransactionAggregateE()
            )
        );

        $this->transactionR = new TransactionAggregateR(
            new OptionsHouseTransactionM(),
            new Collection(),
            new TransactionAggregateE()
        );

        Artisan::call('db:seed', ['--class' => SeedFixtureOptionsHouseTransaction::class]);
    }

    public function tearDown()
    {
        $this->symbolsS = null;
        $this->transactionR = null;

        parent::tearDown();
    }

    /**
     *  data may or may not be contained in the symbols table.
     */
    public function testSymbolsUnique()
    {
        $allSymbols = $this->symbolsS->symbolsUnique();

        $transSymbols = $this->transactionR->symbolsUnique();

        $this->assertSame(count($allSymbols), count($transSymbols));
        $this->assertGreaterThan(0, count($transSymbols));
    }

    /**
     * - get unique symbols from the options_house_transactions table.
     * - populate the symbols table.
     * - delete records from the options_house_transactions table.
     * - perform a symbolsS->symbolsUnique(), which should pick up symbols from the symbols table.
     * - compare the counts.
     */
    public function testPopulateSymbolsTable()
    {
        $tomorrow = Carbon::now()->addDays(1);

        // verify that we are using sqlite_testing db...
        $config = DB::getConfig();
        $this->assertSame('sqlite_testing', $config['name']);

        // check to make sure the options_house_transaction table is not empty.
        $count1 = DB::table('options_house_transaction')->count();
        $this->assertGreaterThan(0, $count1);

        DB::beginTransaction();
        {
            // remove all rows from the symbols table.
            /** @var SymbolsR $repoS */
            $repoS = $this->symbolsS->getSymbolsR();
            $repoS->getModel()
                ->newQuery()
                ->where('created_at', '<=', $tomorrow)
                ->delete();

            // get symbols from options_house_transaction table
            $transSymbols = $this->transactionR->symbolsUnique();

            // populate the symbols table
            $this->symbolsS->populateSymbolsTable();

            // remove all rows from the options_house_table
            DB::table('options_house_transaction')
                ->where('created_at', '<=', $tomorrow)
                ->delete();

            $count = DB::table('options_house_transaction')->count();

            // check to make sure the options_house_transaction table is empty.
            $this->assertSame(0, $count);

            // get symbols from the symbols table; only the symbols table and not the options_house_transaction table
            // should have records.
            $symbols = $this->symbolsS->symbolsUnique();

            // compare the two.
            $this->assertSame(count($transSymbols), count($symbols));
        }
        DB::rollBack();

        //verify rollback worked..
        $count2 = DB::table('options_house_transaction')->count();

        // check to make sure the options_house_transaction table is not empty.
        $this->assertSame($count1, $count2);
    }
}
