<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class ClosedTradeController.
 */
class ClosedTradeController extends Controller
{
    /**
     * @param Request $request
     *
     * @return array
     */
    public function getTradeDetails(Request $request)
    {
//        $user = Auth::user();
        $user = $request->user();

        $results = [];

        foreach ($this->getData() as $row) {
            $result = [];
            $result['close_date'] = $row[0];
            $result['underlier_symbol'] = $row[1];
            $result['option_type'] = $row[2];
            $result['option_side'] = $row[3];
            $result['quantity'] = $row[4];
            $result['amount'] = $row[5];
            $result['profits'] = $row[6];
            $results[] = $result;
        }

        return $results;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return [
            ['2016-02-28', 'SWN', 'PUT', 'SELL', '4', '500.00', '500.00'],
            ['2016-04-01', 'SWN', 'PUT', 'BUY', '4',  '-800.00', ''],
            ['2016-04-01', 'SWN', 'PUT', 'SELL', '6', '1200.00', '400.00'],
        ];
    }
}
