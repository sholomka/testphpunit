<?php


namespace App\DTO;

/**
 * Class BinListDTO
 * @package App\DTO
 */
class BinListDTO
{
    private array $binList;

    /**
     * BinlistDTO constructor.
     * @param $binList
     */
    public function __construct(array $binList)
    {
        $this->binList = $binList;
    }

    /**
     * @return string
     */
    public function getCountryIso(): string
    {
        return $this->binList['country']['alpha2'];
    }
}
