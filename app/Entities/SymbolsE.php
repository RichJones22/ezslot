<?php

declare(strict_types=1);

namespace App\Repositories;

class SymbolsE extends BaseEntity
{
    /** @var string */
    private $underlier_symbol;
    /** @var string */
    private $security_description;

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
     * @return SymbolsE
     */
    public function setUnderlierSymbol(string $underlier_symbol): SymbolsE
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
     * @return SymbolsE
     */
    public function setSecurityDescription(string $security_description): SymbolsE
    {
        $this->security_description = $security_description;

        return $this;
    }
}
