<?php

declare(strict_types=1);

namespace App\Entities;

use Illuminate\Support\Str;
use Psy\Util\Json;

class ClosedTradeE extends BaseEntity
{
    /** @var string */
    private $close_date;
    /** @var string */
    private $underlier_symbol;
    /** @var Json */
    private $trade_details;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return string
     */
    public function getCloseDate(): string
    {
        return $this->close_date;
    }

    /**
     * @param string $close_date
     *
     * @return ClosedTradeE
     */
    public function setCloseDate(string $close_date): ClosedTradeE
    {
        $this->close_date = $close_date;

        return $this;
    }

    /**
     * @return string
     */
    public function getUnderlierSymbol(): string
    {
        return $this->underlier_symbol;
    }

    /**
     * @param string $underlier_symbol
     *
     * @return ClosedTradeE
     */
    public function setUnderlierSymbol(string $underlier_symbol): ClosedTradeE
    {
        $this->underlier_symbol = $underlier_symbol;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTradeDetails()
    {
        return $this->trade_details;
    }

    /**
     * @param string $trade_details
     *
     * @return ClosedTradeE
     */
    public function setTradeDetails(string $trade_details): ClosedTradeE
    {
        $this->trade_details = $trade_details;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $result = [];

        $vars = get_class_vars(get_class($this));
        foreach ($vars as $key => $value) {
            $method = 'get'.ucfirst(Str::camel($key));
            $result[$key] = $this->$method();
        }

        return $result;
    }
}
