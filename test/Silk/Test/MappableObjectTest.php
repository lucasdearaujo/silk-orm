<?php

namespace Silk\Test;

use Silk\Exchanger\OExchanger;

/**
 * Class MappableObjectTest
 * @author  Lucas A. de Araújo <lucas@painapp.com.br>
 * @package Silk\Test
 */
class MappableObjectTest extends \PHPUnit_Framework_TestCase
{

    public function testOutputExchange()
    {
        $carro = new RandomObject();
        $array = OExchanger::toArray($carro);
        var_dump($array);
    }
}