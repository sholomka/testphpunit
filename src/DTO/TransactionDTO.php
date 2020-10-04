<?php

namespace App\DTO;

/**
 * Class TransactionDTO
 * @package App\DTO
 */
final class TransactionDTO
{
    /**
     * @var array
     */
    private array $transaction;

    /**
     * TransactionDTO constructor.
     * @param array $transaction
     */
    public function __construct(array $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * @return string
     */
    public function getBin(): string
    {
        return $this->transaction['bin'];
    }

    /**
     * @return string
     */
    public function getAmount(): string
    {
        return $this->transaction['amount'];
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->transaction['currency'];
    }
}
