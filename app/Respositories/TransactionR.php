<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\Repositories\BaseRepositoryContract;
use App\Entities\TransactionE;
use App\Models\OptionsHouseTransactionM;
use App\Repositories\BaseRepository;
use Illuminate\Support\Collection;
use App\Entities\BaseEntity;

/**
 * Class TransactionR.
 */
class TransactionR extends BaseRepository implements BaseRepositoryContract
{
    /**
     * TransactionR constructor.
     *
     * @param TransactionE             $transactionE
     * @param OptionsHouseTransactionM $transactionM
     * @param Collection               $collection
     */
    public function __construct(
        TransactionE $transactionE,
        OptionsHouseTransactionM $transactionM,
        Collection $collection)
    {
        /** @var BaseEntity $transactionE */
        parent::__construct($transactionE, $transactionM, $collection);
    }
}
