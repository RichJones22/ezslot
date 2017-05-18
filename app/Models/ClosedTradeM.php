<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClosedTradeM extends Model
{
    /**
     *  table used by this model.
     */
    protected $table = 'closed_trades';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'close_date',
        'underlier_symbol',
        'security_description',
        'position_state',
        'option_side',
        'option_quantity',
        'strike_price',
        'expiration',
        'amount',
        'symbol',
        'transaction_id',
    ];
}
