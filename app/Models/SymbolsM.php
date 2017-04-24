<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SymbolsM extends Model
{
    /**
     *  table used by this model.
     */
    protected $table = 'symbols';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'underlier_symbol',
        'security_description',
    ];
}
