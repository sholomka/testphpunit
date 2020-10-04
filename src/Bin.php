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
     * Bin constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return false|string
     */
    public function getList()
    {
        $binList = file_get_contents(getenv('BIN_LIST_URI') . $this->name);

        return new BinListDTO(json_decode($binList, true));
    }
}
