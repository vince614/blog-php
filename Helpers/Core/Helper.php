<?php
namespace Helpers\Core;

/**
 * Class Data
 * @package Helpers\Core
 */
class Helper
{
    /**
     * Array to string
     *
     * @param $array
     * @param string $glue
     * @return string
     */
    public function toString($array, $glue = ",")
    {
        return implode($glue, $array);
    }
}