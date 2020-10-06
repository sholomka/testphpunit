<?php

namespace App;

use App\Clients\HttpClient;
use App\DTO\BinListDTO;

/**
 * Class Bin
 * @package App
 */
class Bin
{
    /**
     * @var string
     */
    private string $name;

    /**
     * @var HttpClient
     */
    private HttpClient $httpClient;

    /**
     * Bin constructor.
     */
    public function __construct()
    {
        $this->httpClient = new HttpClient();
    }

    /**
     * @return BinListDTO
     */
    public function getList(): BinListDTO
    {
        $binList = $this->httpClient->fetchBinListUrl($this->name);

        return new BinListDTO(json_decode($binList, true));
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
