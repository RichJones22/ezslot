<?php declare(strict_types=1);

namespace App\Repositories;

use App\Entities\WelcomeEmailLeadsE;
use App\Models\WelcomeEmailLeadsM;
use Illuminate\Support\Collection;

class WelcomeEmailLeadsR extends BaseRepository
{
    public function __construct(
        WelcomeEmailLeadsE $welcomeEmailLeadsE,
        WelcomeEmailLeadsM $welcomeEmailLeadsM,
        Collection $collection)
    {
        parent::__construct($welcomeEmailLeadsE, $welcomeEmailLeadsM, $collection);
    }
}
