<?php

namespace Silk\Exchange\Populator;

use Silk\Configuration\PropertyConfiguration;

/**
 * Class Processor
 * @author  Lucas A. de Araújo <lucas@painapp.com.br>
 * @package Silk\Exchange\Populator
 */
class Processor
{
    /**
     * Retorna o nome da propriedade, levando em cosideração
     * a existencia de apelidos de conversão.
     *
     * @param PropertyConfiguration $configuration
     * @return string
     */
    public static function getAlias(PropertyConfiguration $configuration)
    {
        if($configuration->hasAlias())
        {
            return $configuration->getAlias();
        }
        else
        {
            return $configuration->getName();
        }
    }
}