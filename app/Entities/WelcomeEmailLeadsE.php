<?php

declare(strict_types=1);

namespace App\Entities;

class WelcomeEmailLeadsE extends BaseEntity
{
    /** @var string */
    private $email;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return WelcomeEmailLeadsE
     */
    public function setEmail(string $email): WelcomeEmailLeadsE
    {
        $this->email = $email;

        return $this;
    }
}
