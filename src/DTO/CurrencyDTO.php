<?php

namespace App\DTO;

use App\Currency;

/**
 * Class CurrencyDTO
 * @package App\DTO
 */
final class CurrencyDTO
{
    /**
     * @var Currency
     */
    private Currency $currency;

    /**
     * CurrencyDTO constructor.
     * @param Currency $currency
     */
    public function __construct(Currency $currency)
    {
        $this->currency = $currency;
    }

    /**
     * @return int|mixed
     */
    public function getRate()
    {
        return $this->currency->getRatesList()['rates'][$this->currency->getName()] ?? 0;
    }
}
