<?php
/**
 * @SWG\Get(
 *     path="/api/getTradeDetails",
 *     summary="derives trade details for a given closed trade",
 *     tags={"Closed Trades"},
 *     schemes={"http"},
 *     produces={"application/json"},
 *     @SWG\Response(
 *         response=200,
 *         description="successful operation",
 *      ),
 *     @SWG\Parameter(
 *          name="close_date",
 *          in="query",
 *          description="date the trade closed, ie: YYYY-MM-DD format",
 *          required=true,
 *          type="string"
 *      ),
 *     @SWG\Parameter(
 *          name="symbol",
 *          in="query",
 *          description="ticker symbol, ie: IBM",
 *          required=true,
 *          type="string"
 *      )
 * )
 */
Route::get('/getTradeDetails','ClosedTradeController@getTradeDetails');
