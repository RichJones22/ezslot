<?php

use App\database\fixtures\SeedOptionsHouseTransaction;
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
         $this->call(SeedOptionsHouseTransaction::class);
    }
}
