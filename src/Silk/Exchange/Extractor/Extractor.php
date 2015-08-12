<?php

namespace Silk\Exchange\Extractor;

use Collections\Dictionary;
use PhpDocReader\Reader;

/**
 * Class Extractor
 * Responsável por executar a extração dos dados do objeto.
 * @author  Lucas A. de Araújo <lucas@painapp.com.br>
 * @package Silk\Exchange\Extractor
 */
class Extractor
{
    /**
     * @param $object
     * @return array
     * @throws \Collections\Exception\KeyException
     */
    private static function map($object)
    {
        $properties = [];

        foreach((new \ReflectionClass($object))->getProperties() as $property)
        {
            $property->setAccessible(true);
            $o = $property->getDeclaringClass()->getName();
            $p = $property->getName();

            $properties[] = [
                'name'   => $p,
                'data'   => $property->getValue($object),
                'config' => Reader::getConfig($o, $p)
            ];
        }

        return $properties;
    }

    /**
     * Extrai as informações existentes em uma classe
     * @param $object
     * @return array
     */
    public static function extract($object)
    {
        $processor = new Processor();
        return $processor->process(self::map($object));
    }
}