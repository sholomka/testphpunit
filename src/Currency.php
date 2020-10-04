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
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getRate(): ?float
    {
        $rates = file_get_contents(getenv('CURRENCY_RATE_URI'));
        $this->ratesList = @json_decode($rates, true);

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
}
