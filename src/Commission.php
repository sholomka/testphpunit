<?php

namespace App;

use App\DTO\TransactionDTO;
use Exception;

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
    public string $transactionCurrency;

    /**
     * @var float|mixed|null
     */
    private $rate;

    /**
     * @var string
     */
    private string $amount;

    /**
     * @var Card
     */
    private Card $card;

    /**
     * @var string
     */
    private string $countryIso;
    /**
     * @var TransactionDTO
     */
    private TransactionDTO $transaction;
    /**
     * @var null|Bin
     */
    private ?Bin $bin = null;

    /**
     * @var null|Currency
     */
    private ?Currency $currency = null;

    /**
     * Commission constructor.
     */
    public function __construct()
    {
        $this->card = new Card();
    }

    /**
     * @param array $argv
     * @return void
     */
    public function calculate(array $argv): void
    {
        $fileContent = $this->getFileContent($argv);

        foreach ($fileContent as $json) {
            try {
                echo $this->getResult($json) . PHP_EOL;
            } catch (Exception $e) {
            }
        }
    }

    public function setBin(Bin $bin): void
    {
        $this->bin = $bin;
    }

    public function setCurrency(Currency $currency): void
    {
        $this->currency = $currency;
    }

    public function setTransaction(string $json)
    {
        $this->transaction =  new TransactionDTO(json_decode($json, true));
    }


    /**
     * @param string $json
     *
     * @throws Exception
     */
    public function getResult(string $json)
    {
        if (empty($json)) {
            throw new Exception('json empty');
        }

//        $transaction = new TransactionDTO(json_decode($json, true));
        $this->setTransaction($json);
        $this->amount = $this->transaction->getAmount();
        $this->transactionCurrency = $this->transaction->getCurrency();

        if (is_null($this->bin)) {
            $this->setBin(new Bin());
        }

        $this->bin->setName($this->transaction->getBin());

        $binResults = $this->bin->getList();

        if (!$binResults) {
            throw new Exception('bin results is empty');
        }

        $this->countryIso = $binResults->getCountryIso();

        if (is_null($this->currency)) {
            $this->setCurrency(new Currency());
        }

        $this->currency->setName($this->transactionCurrency);

        $this->rate = $this->currency->getRate();

        return $this->getAmntFixed() * $this->getRatio();
    }

    /**
     *
     */
    private function getRatio()
    {
        return $this->card->isEurope($this->countryIso) ? self::AMNT_EUROPE_RATIO : self::AMNT_STANDARD_RATIO;
    }

    /**
     * @param $argv
     * @return array
     */
    public function getFileContent($argv): array
    {
        return explode(PHP_EOL, file_get_contents(end($argv)));
    }

    /**
     * @return bool
     */
    private function isCurrencyEuropeOrRateIsZero(): bool
    {
        return $this->transactionCurrency === Currency::EUR || $this->rate === 0;
    }

    /**
     * @return bool
     */
    private function isCurrencyNotEuropeOrRateIsGraterThanZero(): bool
    {
        return $this->transactionCurrency !== Currency::EUR or $this->rate > 0;
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

    /**
     * @return TransactionDTO
     */
    public function getTransaction(): TransactionDTO
    {
        return $this->transaction;
    }
}
