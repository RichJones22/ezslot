<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\WelcomeEmailLeadsR;

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
}
