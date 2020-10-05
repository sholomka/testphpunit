<?php


namespace App;

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
     * Currency constructor.
     * @param string $name
     */
    public function __construct()
    {

    }

    /**
     * @return mixed
     */
    public function getRate()
    {
        $rates = file_get_contents(getenv('CURRENCY_RATE_URI'));
        $this->ratesList = @json_decode($rates, true);

        var_dump( $rates);

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
