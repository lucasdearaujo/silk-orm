<?php

namespace Silk\Exchange\Populator;

/**
 * Class Processor
 *
 * Classe responsável por fazer o processamento das informações
 * que devem ser inseridas nos objetos.
 *
 * @author  Lucas A. de Araújo <lucas@painapp.com.br>
 * @package Silk\Exchange\Populator
 */
class Processor
{
    /**
     * Retorna a configuração de uma propriedade de um objeto
     * mapeada com a classe ReflectionClass.
     *
     * @param \ReflectionProperty $property
     * @return array
     */
    public static function getPropertyConfig(\ReflectionProperty $property)
    {
        return [];
    }
}