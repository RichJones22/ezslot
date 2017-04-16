<?php

declare(strict_types=1);

namespace App\Services;

/**
 * Class TransactionS.
 */
class TransactionS
{
    /**
     * @var TransactionR
     */
    private $transactionR;

    /**
     * TransactionS constructor.
     *
     * @param TransactionR $transactionR
     */
    public function __construct(TransactionR $transactionR)
    {
        $this->setTransactionR($transactionR);
    }

    /**
     * @return TransactionR
     */
    public function getTransactionR(): TransactionR
    {
        return $this->transactionR;
    }

    /**
     * @param TransactionR $transactionR
     *
     * @return TransactionS
     */
    public function setTransactionR(TransactionR $transactionR): TransactionS
    {
        $this->transactionR = $transactionR;

        return $this;
    }
}
