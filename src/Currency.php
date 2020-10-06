<?php

namespace App;

use App\Clients\HttpClient;
use App\DTO\CurrencyDTO;

/**
 * Class Currency
 * @package App
 */
class Currency
{
    public const EUR = 'EUR';

    /**
     * @var string
     */
    private string $name;

    /**
     * @var mixed
     */
    private $ratesList;

    /**
     * @var HttpClient
     */
    private HttpClient $httpClient;

    /**
     * Currency constructor.
     */
    public function __construct()
    {
        $this->httpClient = new HttpClient();
    }

    /**
     * @return mixed
     */
    public function getRate()
    {
        $this->ratesList = @json_decode($this->httpClient->fetchCurrencyUrl(), true);

        return (new CurrencyDTO($this))->getRate();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getRatesList()
    {
        return $this->ratesList;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
