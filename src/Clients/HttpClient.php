<?php

namespace App\Clients;

/**
 * Class HttpClient
 * @package App\Clients
 */
class HttpClient
{
    /**
     * @return false|string
     */
    public function fetchCurrencyUrl()
    {
        return file_get_contents(getenv('CURRENCY_RATE_URI'));
    }

    /**
     * @param $binName
     * @return false|string
     */
    public function fetchBinListUrl($binName)
    {
        return file_get_contents(getenv('BIN_LIST_URI') . $binName);
    }
}
