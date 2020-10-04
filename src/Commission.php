<?php

namespace App;

use App\DTO\TransactionDTO;

/**
 * Class Commission
 * @package App
 */
class Commission
{
    private const AMNT_STANDARD_RATIO = 0.02;

    private const AMNT_EUROPE_RATIO = 0.01;

    /**
     * @var string
     */
    private string $currency;

    /**
     * @var float|mixed|null
     */
    private $rate;

    /**
     * @var string
     */
    private string $amount;

    /**
     * @var array
     */
    private array $fileContent;

    /**
     * @var Card
     */
    private Card $card;

    /**
     * @var string
     */
    private string $countryIso;

    /**
     * Commission constructor.
     * @param array $argv
     */
    public function __construct(array $argv)
    {
        $this->fileContent = $this->getFileContent($argv);
        $this->card = new Card();
    }

    /**
     * @return void
     */
    public function calculate(): void
    {
        foreach ($this->fileContent as $json) {
            if (empty($json)) {
                break;
            }

            $transaction = new TransactionDTO(json_decode($json, true));
            $this->amount = $transaction->getAmount();
            $this->currency = $transaction->getCurrency();
            $binResults = (new Bin($transaction->getBin()))->getList();

            if (!$binResults) {
                break;
            }

            $this->countryIso = $binResults->getCountryIso();
            $this->rate = (new Currency($this->currency))->getRate();

            echo $this->getAmntFixed() * $this->getRatio() . PHP_EOL;
        }
    }

    /**
     * @return float
     */
    private function getRatio(): float
    {
        return $this->card->isEurope($this->countryIso) ? self::AMNT_EUROPE_RATIO : self::AMNT_STANDARD_RATIO;
    }

    /**
     * @param $argv
     * @return array
     */
    private function getFileContent($argv): array
    {
        return explode(PHP_EOL, file_get_contents($argv[1]));
    }

    /**
     * @return bool
     */
    private function isCurrencyEuropeOrRateIsZero(): bool
    {
        return $this->currency === Currency::EUR || $this->rate === 0;
    }

    /**
     * @return bool
     */
    private function isCurrencyNotEuropeOrRateIsGraterThanZero(): bool
    {
        return $this->currency !== Currency::EUR or $this->rate > 0;
    }

    /**
     * @return float|int|string
     */
    private function getAmntFixed()
    {
        $amntFixed = 0;

        if ($this->isCurrencyEuropeOrRateIsZero()) {
            $amntFixed = $this->amount;
        }

        if ($this->isCurrencyNotEuropeOrRateIsGraterThanZero()) {
            $amntFixed = $this->amount / $this->rate;
        }

        return $amntFixed;
    }
}
