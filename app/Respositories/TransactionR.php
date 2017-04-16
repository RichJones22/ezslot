<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\Repositories\BaseRepositoryContract;
use App\Entities\TransactionE;
use App\OptionsHouseTransaction;
use App\Repositories\BaseEntity;
use App\Repositories\BaseRepository;
use Illuminate\Support\Collection;

/**
 * Class TransactionR.
 */
class TransactionR extends BaseRepository implements BaseRepositoryContract
{
    /**
     * TransactionR constructor.
     *
     * @param TransactionE            $transactionE
     * @param OptionsHouseTransaction $transactionM
     * @param Collection              $collection
     */
    public function __construct(
        TransactionE $transactionE,
        OptionsHouseTransaction $transactionM,
        Collection $collection)
    {
        /* @var BaseEntity $transactionE */
        parent::__construct($transactionE, $transactionM, $collection);
    }
}
