<?php

namespace App;

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
     * @return false|string
     */
    public function getList()
    {
        $binList = $this->fetchUrl();

        return new BinListDTO(json_decode($binList, true));
    }


    public function fetchUrl()
    {
        return file_get_contents(getenv('BIN_LIST_URI') . $this->name);
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
