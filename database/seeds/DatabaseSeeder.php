<?php

use App\database\fixtures\SeedFixtureOptionsHouseTransaction;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(SeedFixtureOptionsHouseTransaction::class);
    }
}
