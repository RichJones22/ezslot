<?php declare(strict_types=1);

namespace App\Entities;

class TransactionE extends BaseEntity
{
    /** @var string */
    private $close_date;
    /** @var string */
    private $underlier_symbol;
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
     * @return TransactionE
     */
    public function setCloseDate(string $close_date): TransactionE
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
     * @return TransactionE
     */
    public function setUnderlierSymbol(string $underlier_symbol): TransactionE
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
     * @return TransactionE
     */
    public function setPositionState(string $position_state): TransactionE
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
     * @return TransactionE
     */
    public function setOptionSide(string $option_side): TransactionE
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
     * @return TransactionE
     */
    public function setOptionQuantity(int $option_quantity): TransactionE
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
     * @return TransactionE
     */
    public function setStrikePrice(float $strike_price): TransactionE
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
     * @return TransactionE
     */
    public function setExpiration(string $expiration): TransactionE
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
     * @return TransactionE
     */
    public function setAmount(float $amount): TransactionE
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
     * @return TransactionE
     */
    public function setSymbol(string $symbol): TransactionE
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
     * @return TransactionE
     */
    public function setTransactionId(int $transaction_id): TransactionE
    {
        $this->transaction_id = $transaction_id;

        return $this;
    }
}
