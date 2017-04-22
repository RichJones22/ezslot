<?php declare(strict_types=1);

namespace App\database\fixtures;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Seeder;
use Schema;

class SeedFixtureOptionsHouseTransaction extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        if (Schema::hasTable('options_house_transaction')) {

            DB::table('options_house_transaction')->truncate();

            foreach ($this->data() as $row) {
                DB::table('options_house_transaction')->insert([
                    'transaction_id' => $row[0],
                    'close_date' => $row[1],
                    'close_time' => $row[2],
                    'trade_type' => $row[3],
                    'description' => $row[4],
                    'strike_price' => $row[5],
                    'option_type' => $row[6],
                    'option_side' => $row[7],
                    'option_quantity' => $row[8],
                    'symbol' => $row[9],
                    'price_per_unit' => $row[10],
                    'underlier_symbol' => $row[11],
                    'fee' => $row[12],
                    'commission' => $row[13],
                    'amount' => $row[14],
                    'security_type' => $row[15],
                    'expiration' => $row[16],
                    'security_description' => $row[17],
                    'position_state' => $row[18],
                    'deliverables' => $row[19],
                    'market_statistics' => $row[20],
                    'trade_journal_notes' => $row[21],
                    'created_at' => new Carbon(),
                    'updated_at' => new Carbon(),
                ]);
            }
        }
    }

    private function data()
    {
        return [
            [55798239, '2012-11-15', '12:15:01', 'Trade', 'Bought 1 RUT Dec12 830 call (RUT   121222C00830000) @ $1.50', 830, 'CALL', 'BUY', 1, 'RUT   121222C00830000', 0, 'RUT', 0.03, 8.65, -158.68, 'Option', '2012-12-22', '', 'CLOSE', '', '', '', '2017-04-22 03:20:39', '2017-04-22 03:20:39'],
            [55721944, '2012-11-13', '01:00:00', 'Deposit', 'Settled ACH Deposit', 0, '', '', null, '', 1, '', 0, 0, 25000, '', null, '', '', '', '', '', '2017-04-22 03:20:39', '2017-04-22 03:20:39'],
            [54026981, '2012-09-24', '01:04:46', 'Trade', 'Bought 7 IWM Oct12 90 call (IWM   121020C00090000) @ $.07', 90, 'CALL', 'BUY', 7, 'IWM   121020C00090000', 0, 'IWM', 0.2, 1.05, -50.25, 'Option', '2012-10-20', '', 'OPEN', '', '', '', '2017-04-22 03:20:39', '2017-04-22 03:20:39'],
            [54026980, '2012-09-24', '01:04:46', 'Trade', 'Sold 14 IWM Oct12 87 call (IWM   121020C00087000) @ $.45', 87, 'CALL', 'SELL', 14, 'IWM   121020C00087000', 0, 'IWM', 0.45, 2.1, 627.45, 'Option', '2012-10-20', '', 'OPEN', '', '', '', '2017-04-22 03:20:39', '2017-04-22 03:20:39'],
            [1000056994978, '2017-01-20', '09:30:01', 'Trade', 'Bought 9 P Mar17 12 put (PO1717C012000) @ $0.61', 12, 'PUT', 'BUY', 9, 'PO1717C012000', 0, 'P', 0.37, 1.35, -550.72, 'Option', '2017-03-17', 'Pandora Media Ord Shs', 'CLOSE', 'P P 100.0 100 null null  P : 100', '', '', '2017-04-22 03:20:34', '2017-04-22 03:20:34'],
            [1000056994969, '2017-01-20', '09:30:01', 'Trade', 'Bought 4 P Mar17 12 put (PO1717C012000) @ $0.62', 12, 'PUT', 'BUY', 4, 'PO1717C012000', 0, 'P', 0.16, 13.1, -261.26, 'Option', '2017-03-17', 'Pandora Media Ord Shs', 'CLOSE', 'P P 100.0 100 null null  P : 100', '', '', '2017-04-22 03:20:34', '2017-04-22 03:20:34'],
            [1000052177321, '2016-10-07', '10:20:08', 'Trade', 'Sold 2 PBI Nov16 18 put (PBIW1816C018000) @ $0.96', 18, 'PUT', 'SELL', 2, 'PBIW1816C018000', 0, 'PBI', 0.1, 0.3, 191.6, 'Option', '2016-11-18', 'Pitney Bowes Ord Shs', 'OPEN', 'PBI PBI 100.0 100 null null  PBI : 100', '', '', '2017-04-22 03:20:35', '2017-04-22 03:20:35'],
        ];
    }
}
