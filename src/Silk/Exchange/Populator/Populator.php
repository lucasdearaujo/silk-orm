<?php

namespace Silk\Exchange\Populator;

use ReflectionClass;
use Silk\Configuration\PropertyConfiguration;

/**
 * Class Populator
 *
 * Responsável por fazer a leitura da array e popular
 * os objetos com base nos valores recebidos do banco de dados,
 * e também com base nas configurações definidas para o objeto.
 *
 * @author  Lucas A. de Araújo <lucas@painapp.com.br>
 * @package Silk\Exchange\Populator
 */
class Populator
{
    /**
     * Popula um objeto com os valores definidos na array identificado
     * cada um de acordo com a configuração da classe, em relação ao produto
     * final que ela deve produzir na extração dos dados.
     *
     * @param $object
     * @param $array
     */
    public static function populate(&$object, $array)
    {
        foreach((new ReflectionClass($object))->getProperties() as $property)
            self::setProperty($object, $property, $array);

        self::afterPopulate($object, $array);
    }

    /**
     * Define o conteúdo de uma propriedade lendo as regras relacionadas
     * a mesma, e seguindo a estratégia adequada para cada situação.
     *
     * @param $object
     * @param $property
     * @param $array
     */
    public static function setProperty(&$object, \ReflectionProperty &$property, $array)
    {
        $property->setAccessible(true);
        $configuration = new PropertyConfiguration($property, $object);
        $value = null;
        $alias = $configuration->getAlias();

        // Se o campo for do tipo que deve ser ignorado,
        // não meche nele...
        if($configuration->ignore())
            return;

        if(array_key_exists($alias, $array))
            $value = $array[$alias];

        $property->setValue($object, $value);
    }

    /**
     * @param $object
     * @param $array
     */
    public static function afterPopulate(&$object, $array)
    {
        // Verifica se existe o método que trata os
        // valores após eles terem sido populados.
        // Se tiver, o executa.
        if(method_exists($object, 'afterPopulate'))
        {
            call_user_func('afterPopulate', $object, [$array]);
        }
    }
}