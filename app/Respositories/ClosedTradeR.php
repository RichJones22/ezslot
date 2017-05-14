<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\Repositories\BaseRepositoryContract;
use App\Entities\BaseEntity;
use App\Entities\ClosedTradeE;
use App\Models\ClosedTradeM;
use App\Repositories\BaseRepository;
use Illuminate\Support\Collection;

/**
 * Class ClosedTradeR.
 */
class ClosedTradeR extends BaseRepository implements BaseRepositoryContract
{
    /**
     * ClosedTradeR constructor.
     *
     * @param ClosedTradeE $closedTradeE
     * @param ClosedTradeM $closedTradeM
     * @param Collection   $collection
     */
    public function __construct(
        ClosedTradeE $closedTradeE,
        ClosedTradeM $closedTradeM,
        Collection $collection)
    {
        /* @var BaseEntity $closedTradeE */
        parent::__construct($closedTradeE, $closedTradeM, $collection);
    }

    public function getClosedTradeByDateAndSymbol(string $closeDate, string $symbol)
    {
        $collection = $this->getModel()
            ->newQuery()
            ->select('close_date', 'underlier_symbol', 'trade_details')
            ->where('close_date', '=', $closeDate)
            ->where('underlier_symbol', '=', $symbol)
            ->get()
        ;

        return $this->hydrateEntity($collection);
    }
}
