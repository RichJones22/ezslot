<?php declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionM extends Model
{
    /**
     *  table used by this model.
     */
    protected $table = 'transactions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'transaction_id',
        'close_date',
        'close_time',
        'trade_type',
        'description',
        'strike_price',
        'option_type',
        'option_side',
        'option_quantity',
        'symbol',
        'price_per_unit',
        'underlier_symbol',
        'fee',
        'commission',
        'amount',
        'security_type',
        'expiration',
        'security_description',
        'position_state',
        'deliverables',
        'market_statistics',
        'trade_journal_notes',
    ];
}
