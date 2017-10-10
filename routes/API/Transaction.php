<?php
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
