<?php

namespace App;

/**
 * Class Card
 * @package App
 */
class Card
{
    /**
     * @param string $countryIso
     * @return bool
     */
    public function isEurope(string $countryIso): bool
    {
        return in_array($countryIso, IsoCode::EUROPE_ISO_CODES);
    }
}
