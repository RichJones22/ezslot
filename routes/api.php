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