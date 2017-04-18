<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Repositories\SymbolsRContract;
use App\OptionsHouseTransactionM;
use DB;
use Illuminate\Support\Collection;

/**
 * Class SymbolsR.
 */
class SymbolsR extends BaseRepository implements SymbolsRContract
{
    /**
     * SymbolsR constructor.
     *
     * @param SymbolsE                 $entity
     * @param OptionsHouseTransactionM $model
     * @param Collection               $collection
     */
    public function __construct(
        SymbolsE $entity,
        OptionsHouseTransactionM $model, // TODO:  SymbolsR should not be using OptionsHouseTransactionM a a model.
                                        // TODO:  We need to finish the TransactionsR.  This would would then be used by this
                                        // TODO:  service... Need to to this next!
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

    public function rowExistsByUnderlierSymbol(SymbolsE $symbolsE)
    {
        $counts = $this->getModel()
            ->newQuery()
            ->select(DB::raw('count(*) as count'))
            ->where('underlier_symbol', $symbolsE->getUnderlierSymbol())
            ->get();

        foreach ($counts as $count) {
            return $count->count;
        }

        return false;
    }
}
