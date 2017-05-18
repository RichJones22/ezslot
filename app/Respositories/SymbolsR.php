<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Repositories\SymbolsRContract;
use App\Models\SymbolsM;
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
     * @param SymbolsE   $entity
     * @param SymbolsM   $model
     * @param Collection $collection
     */
    public function __construct(
        SymbolsE $entity,
        SymbolsM $model,
        Collection $collection
    ) {
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
