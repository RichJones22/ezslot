<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\WelcomeEmailLeadsE;
use App\Models\WelcomeEmailLeadsM;
use Illuminate\Support\Collection;

/**
 * Class WelcomeEmailLeadsR.
 */
class WelcomeEmailLeadsR extends BaseRepository
{
    /**
     * WelcomeEmailLeadsR constructor.
     *
     * @param WelcomeEmailLeadsE $welcomeEmailLeadsE
     * @param WelcomeEmailLeadsM $welcomeEmailLeadsM
     * @param Collection         $collection
     */
    public function __construct(
        WelcomeEmailLeadsE $welcomeEmailLeadsE,
        WelcomeEmailLeadsM $welcomeEmailLeadsM,
        Collection $collection)
    {
        parent::__construct($welcomeEmailLeadsE, $welcomeEmailLeadsM, $collection);
    }

    /**
     * @return Collection
     */
    public function getAllWelcomeEmailLeads()
    {
        $collection = $this->getModel()
            ->newQuery()
            ->select('email')
            ->get()
        ;

        return $this->hydrateEntity($collection);
    }
}
