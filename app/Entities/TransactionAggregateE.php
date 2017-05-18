<?php

declare(strict_types=1);

namespace App\Entities;

use Illuminate\Support\Str;

/**
 * Class TransactionAggregateE.
 */
class TransactionAggregateE
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
    /** @var string */
    private $option_type;
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

    // aggregates
    private $profits;

    /** @var bool */
    private $tradeClosed;

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
     * @return TransactionAggregateE
     */
    public function setCloseDate(string $close_date): TransactionAggregateE
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
     * @return TransactionAggregateE
     */
    public function setUnderlierSymbol(string $underlier_symbol): TransactionAggregateE
    {
        $this->underlier_symbol = $underlier_symbol;

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
     * @return TransactionAggregateE
     */
    public function setSecurityDescription(string $security_description): TransactionAggregateE
    {
        $this->security_description = $security_description;

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
     * @return TransactionAggregateE
     */
    public function setPositionState(string $position_state): TransactionAggregateE
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
     * @return TransactionAggregateE
     */
    public function setOptionSide(string $option_side): TransactionAggregateE
    {
        $this->option_side = $option_side;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getOptionType(): string
    {
        return $this->option_type;
    }

    /**
     * @param string $option_type
     *
     * @return TransactionAggregateE
     */
    public function setOptionType(string $option_type): TransactionAggregateE
    {
        $this->option_type = $option_type;

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
     * @return TransactionAggregateE
     */
    public function setOptionQuantity(int $option_quantity): TransactionAggregateE
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
     * @return TransactionAggregateE
     */
    public function setStrikePrice(float $strike_price): TransactionAggregateE
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
     * @return TransactionAggregateE
     */
    public function setExpiration(string $expiration): TransactionAggregateE
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
     * @return TransactionAggregateE
     */
    public function setAmount(float $amount): TransactionAggregateE
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
     * @return TransactionAggregateE
     */
    public function setSymbol(string $symbol): TransactionAggregateE
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
     * @return TransactionAggregateE
     */
    public function setTransactionId(int $transaction_id): TransactionAggregateE
    {
        $this->transaction_id = $transaction_id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getProfits()
    {
        return $this->profits;
    }

    /**
     * @param mixed $profits
     *
     * @return TransactionAggregateE
     */
    public function setProfits($profits)
    {
        $this->profits = $profits;

        return $this;
    }

    /**
     * @return bool
     */
    public function getTradeClosed(): bool
    {
        return $this->tradeClosed;
    }

    /**
     * @param bool $tradeClosed
     *
     * @return TransactionAggregateE
     */
    public function setTradeClosed(bool $tradeClosed): TransactionAggregateE
    {
        $this->tradeClosed = $tradeClosed;

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
