<?php

namespace Silk\Exchanger;

use Silk\Mapping\ObjectMapper;

/**
 * Class OExchanger
 * @author  Lucas A. de Araújo <lucas@painapp.com.br>
 * @package Silk\Exchanger
 */
class OExchanger
{
    /**
     * @param $object
     * @return array
     */
    public static function toArray($object)
    {
        $mapper = new ObjectMapper();
        $mapper->setObject($object);
        $array = $mapper->toArray();

        return $array;
    }
}