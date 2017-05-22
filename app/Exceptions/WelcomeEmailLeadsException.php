<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class WelcomeEmailLeadsException extends Exception
{
    /**
     * @var string
     */
    private $customResponseMessage;

    public function __construct(string $customResponseMessage)
    {
        $this->customResponseMessage = $customResponseMessage;
    }

    /**
     * @return string
     */
    public function getCustomResponseMessage(): string
    {
        return $this->customResponseMessage;
    }

    /**
     * @param string $customResponseMessage
     *
     * @return WelcomeEmailLeadsException
     */
    public function setCustomResponseMessage(string $customResponseMessage): WelcomeEmailLeadsException
    {
        $this->customResponseMessage = $customResponseMessage;

        return $this;
    }
}
