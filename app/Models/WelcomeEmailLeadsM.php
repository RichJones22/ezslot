<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WelcomeEmailLeadsM extends Model
{
    /**
     *  table used by this model.
     */
    protected $table = 'welcome_email_leads';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
    ];
}
