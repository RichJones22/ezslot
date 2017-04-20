<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\Repositories\BaseRepositoryContract;
use App\Entities\BaseEntity;
use App\Entities\TransactionE;
use App\Models\OptionsHouseTransactionM;
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
     * @param TransactionE             $transactionE
     * @param OptionsHouseTransactionM $transactionM
     * @param Collection               $collection
     */
    public function __construct(
        TransactionE $transactionE,
        OptionsHouseTransactionM $transactionM,
        Collection $collection)
    {
        /* @var BaseEntity $transactionE */
        parent::__construct($transactionE, $transactionM, $collection);
    }

    /**
     * @return Collection
     */
    public function symbolsUnique(): Collection
    {
        $collection = $this->getModel()
            ->newQuery()
            ->select('underlier_symbol', 'security_description')
            ->groupBy('underlier_symbol', 'security_description')
            ->where('underlier_symbol', '<>', '')
            ->where('close_date', '>', self::FROM_DATE)
            ->get()
        ;

        // remove duplicates...
        $collection = $collection->unique('underlier_symbol');

        return $this->hydrateEntity($collection);
    }
}
