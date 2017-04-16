<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Repositories\SymbolsRContract;
use App\OptionsHouseTransaction;
use Illuminate\Support\Collection;

/**
 * Class SymbolsR.
 */
class SymbolsR extends BaseRepository implements SymbolsRContract
{
    /**
     * SymbolsR constructor.
     *
     * @param SymbolsE                $entity
     * @param OptionsHouseTransaction $model
     * @param Collection              $collection
     */
    public function __construct(
        SymbolsE $entity,
        OptionsHouseTransaction $model,
        Collection $collection)
    {
        parent::__construct($entity, $model, $collection);
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

        return $this->hydrateEntity($collection);
    }
}
