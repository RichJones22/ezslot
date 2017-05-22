<?php

declare(strict_types=1);

namespace App\Services;

use App\Entities\WelcomeEmailLeadsE;
use App\Repositories\WelcomeEmailLeadsR;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * Class WelcomeEmailLeadsS.
 */
class WelcomeEmailLeadsS
{
    /**
     * @var WelcomeEmailLeadsR
     */
    private $welcomeEmailLeadsR;

    /**
     * CloseTradeS constructor.
     *
     * @param WelcomeEmailLeadsR $welcomeEmailLeadsR
     */
    public function __construct(WelcomeEmailLeadsR $welcomeEmailLeadsR)
    {
        $this->setWelcomeEmailLeadsR($welcomeEmailLeadsR);
    }

    /**
     * @param Request $request
     */
    public function persistEmail(Request $request)
    {
        try {
            DB::Transaction(function () use ($request) {
                // get and set email address for entity.
                $entity = $this->getNewEntity();
                $entity->setEmail($request->get('email'));

                // persist entity to db.
                $this->getWelcomeEmailLeadsR()
                    ->persistEntity($entity);
            });
        } catch (Throwable $t) {
            if ($t->errorInfo[0] === '23000') { // mysql constraint violation.
                if ($t->errorInfo[1] === 1062) { // mysql duplicate key.
                    // just trap for duplicate row here... still send an email to the user...
                }
            }
        }
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getAllWelcomeEmailLeads()
    {
        return $this->getWelcomeEmailLeadsR()
            ->getAllWelcomeEmailLeads();
    }

    /**
     * @return WelcomeEmailLeadsR
     */
    public function getWelcomeEmailLeadsR(): WelcomeEmailLeadsR
    {
        return $this->welcomeEmailLeadsR;
    }

    /**
     * @param WelcomeEmailLeadsR $welcomeEmailLeadsR
     *
     * @return WelcomeEmailLeadsS
     */
    public function setWelcomeEmailLeadsR(WelcomeEmailLeadsR $welcomeEmailLeadsR): WelcomeEmailLeadsS
    {
        $this->welcomeEmailLeadsR = $welcomeEmailLeadsR;

        return $this;
    }

    /**
     * @return WelcomeEmailLeadsE
     */
    protected function getNewEntity(): WelcomeEmailLeadsE
    {
        /** @var WelcomeEmailLeadsE $entity */
        $entity = $this->getWelcomeEmailLeadsR()->getEntity();
        $entity = new $entity();

        return $entity;
    }
}
