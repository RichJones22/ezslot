<?php

use Swagger\Annotations as SWG;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register the API routes for your application as
| the routes are automatically authenticated using the API guard and
| loaded automatically by this application's RouteServiceProvider.
|
*/

Route::group([
    'middleware' => 'auth:api'
], function () {
});


/**
 * @SWG\Get(
 *     path="/api/closedSymbols",
 *     summary="derive a list of closed transactions",
 *     tags={"Closed Trades"},
 *     schemes={"http"},
 *     produces={"application/json"},
 *     @SWG\Response(
 *         response=200,
 *         description="successful operation",
 *     )
 * )
 */
Route::get('/closedSymbols', 'TransactionController@getSymbolsThatClosedForPeriod');

Route::get('/getTradeDetails','ClosedTradeController@getTradeDetails');
//
//Route::get('/getTradeDetails', function(){
//
//    $results = [];
//
//    foreach (getData() as $row) {
//        $result = [];
//        $result['close_date'] = $row[0];
//        $result['underlier_symbol'] = $row[1];
//        $result['option_type'] = $row[2];
//        $result['option_side'] = $row[3];
//        $result['quantity'] = $row[4];
//        $result['amount'] = $row[5];
//        $result['profits'] = $row[6];
//        $results[] = $result;
//    }
//
//    return $results;
//});
//
//
//function getData() {
//    return [
//        ['2016-02-28', 'SWN', 'PUT', 'SELL', '4', '500.00', '500.00'],
//        ['2016-04-01', 'SWN', 'PUT', 'BUY', '4',  '-800.00', ''],
//        ['2016-04-01', 'SWN', 'PUT', 'SELL', '6', '1200.00', '400.00'],
//    ];
//}
