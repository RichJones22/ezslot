<?php

declare(strict_types=1);

namespace App\Entities;

class ClosedTradeE extends BaseEntity
{
    /** @var string */
    private $close_date;
    /** @var string */
    private $underlier_symbol;
    /** @var string */
    private $security_description;
    /** @var string */
    private $position_state;
    /** @var string */
    private $option_side;
    /** @var int */
    private $option_quantity;
    /** @var float */
    private $strike_price;
    /** @var string */
    private $expiration;
    /** @var float */
    private $amount;
    /** @var string */
    private $symbol;
    /** @var int */
    private $transaction_id;

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
     * @return string
     */
    public function getPositionState(): string
    {
        return $this->position_state;
    }

    /**
     * @param string $position_state
     *
     * @return ClosedTradeE
     */
    public function setPositionState(string $position_state): ClosedTradeE
    {
        $this->position_state = $position_state;

        return $this;
    }

    /**
     * @return string
     */
    public function getOptionSide(): string
    {
        return $this->option_side;
    }

    /**
     * @param string $option_side
     *
     * @return ClosedTradeE
     */
    public function setOptionSide(string $option_side): ClosedTradeE
    {
        $this->option_side = $option_side;

        return $this;
    }

    /**
     * @return int
     */
    public function getOptionQuantity(): int
    {
        return $this->option_quantity;
    }

    /**
     * @param int $option_quantity
     *
     * @return ClosedTradeE
     */
    public function setOptionQuantity(int $option_quantity): ClosedTradeE
    {
        $this->option_quantity = $option_quantity;

        return $this;
    }

    /**
     * @return float
     */
    public function getStrikePrice(): float
    {
        return $this->strike_price;
    }

    /**
     * @param float $strike_price
     *
     * @return ClosedTradeE
     */
    public function setStrikePrice(float $strike_price): ClosedTradeE
    {
        $this->strike_price = $strike_price;

        return $this;
    }

    /**
     * @return string
     */
    public function getExpiration(): string
    {
        return $this->expiration;
    }

    /**
     * @param string $expiration
     *
     * @return ClosedTradeE
     */
    public function setExpiration(string $expiration): ClosedTradeE
    {
        $this->expiration = $expiration;

        return $this;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     *
     * @return ClosedTradeE
     */
    public function setAmount(float $amount): ClosedTradeE
    {
        $this->amount = $amount;

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
     * @return ClosedTradeE
     */
    public function setSymbol(string $symbol): ClosedTradeE
    {
        $this->symbol = $symbol;

        return $this;
    }

    /**
     * @return int
     */
    public function getTransactionId(): int
    {
        return $this->transaction_id;
    }

    /**
     * @param int $transaction_id
     *
     * @return ClosedTradeE
     */
    public function setTransactionId(int $transaction_id): ClosedTradeE
    {
        $this->transaction_id = $transaction_id;

        return $this;
    }

    /**
     * @return string
     */
    public function getSecurityDescription(): string
    {
        return $this->security_description;
    }

    /**
     * @param string $security_description
     *
     * @return ClosedTradeE
     */
    public function setSecurityDescription(string $security_description): ClosedTradeE
    {
        $this->security_description = $security_description;

        return $this;
    }
}
