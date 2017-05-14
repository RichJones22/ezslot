<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Entities\ClosedTradeE;
use App\Services\CloseTradeS;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

/**
 * Class ClosedTradeController.
 */
class ClosedTradeController extends Controller
{
    /**
     * @var CloseTradeS
     */
    private $closeTradeS;
    /** @var string */
    private $closedDate;
    /** @var string */
    private $symbol;

    public function __construct(CloseTradeS $closeTradeS)
    {
        $this->setCloseTradeS($closeTradeS);
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public function getTradeDetails(Request $request)
    {
        $this->setClosedDate($request->get('close_date'));
        $this->setSymbol($request->get('symbol'));

        $data = Cache::get($this->getCacheKey($this->getClosedDate(), $this->getSymbol()));
        if ($data) {
            return json_decode($data);
        }

        $repo = $this->getCloseTradeS()->getClosedTradeR();

        $collection = $repo->getClosedTradeByDateAndSymbol($this->getClosedDate(), $this->getSymbol());

        return $this->convertToJsonableType($collection);
    }

    /**
     * @return CloseTradeS
     */
    public function getCloseTradeS(): CloseTradeS
    {
        return $this->closeTradeS;
    }

    /**
     * @param CloseTradeS $closeTradeS
     *
     * @return ClosedTradeController
     */
    public function setCloseTradeS(CloseTradeS $closeTradeS): ClosedTradeController
    {
        $this->closeTradeS = $closeTradeS;

        return $this;
    }

    /**
     * @return string
     */
    public function getClosedDate(): string
    {
        return $this->closedDate;
    }

    /**
     * @param string $closedDate
     *
     * @return ClosedTradeController
     */
    public function setClosedDate(string $closedDate): ClosedTradeController
    {
        $this->closedDate = $closedDate;

        return $this;
    }

    /**
     * @return string
     */
    public function getSymbol(): string
    {
        return $this->symbol;
    }

    /**
     * @param string $symbol
     *
     * @return ClosedTradeController
     */
    public function setSymbol(string $symbol): ClosedTradeController
    {
        $this->symbol = $symbol;

        return $this;
    }

    protected function getCacheKey(string $closeDate, string $symbol)
    {
        return 'closed_trades:'.$closeDate.':'.$symbol;
    }

    /**
     * @param Collection $collection
     *
     * @return array
     */
    protected function convertToJsonableType(Collection $collection): array
    {
        $data = [];

        // convert the collection to an array
        $closedTrades = $collection->all();

        // convert the array a jsonable return type
        /** @var ClosedTradeE $closedTrade */
        foreach ($closedTrades as $closedTrade) {
            $data[] = $closedTrade->toArray();
        }

        Cache::put($this->getCacheKey($this->getClosedDate(), $this->getSymbol()), json_encode($data), 60);

        return $data;
    }
}
