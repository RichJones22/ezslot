<?php

declare(strict_types=1);

namespace App\Services;

/**
 * Class CloseTradeS.
 */
class CloseTradeS
{
    /**
     * @var ClosedTradeR
     */
    private $transactionR;

    /**
     * CloseTradeS constructor.
     *
     * @param ClosedTradeR $transactionR
     */
    public function __construct(ClosedTradeR $transactionR)
    {
        $this->setTransactionR($transactionR);
    }

    /**
     * @return ClosedTradeR
     */
    public function getTransactionR(): ClosedTradeR
    {
        return $this->transactionR;
    }

    /**
     * @param ClosedTradeR $transactionR
     *
     * @return CloseTradeS
     */
    public function setTransactionR(ClosedTradeR $transactionR): CloseTradeS
    {
        $this->transactionR = $transactionR;

        return $this;
    }
}
