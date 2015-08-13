<?php

namespace Silk\Exchange\Populator;

use ReflectionClass;
use Silk\Configuration\PropertyConfiguration;
use Silk\Exceptions\NoDataFoundException;

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
        {
            $property->setAccessible(true);
            $configuration = new PropertyConfiguration($property);
            $value = null;

            // Se o campo for do tipo que deve ser ignorado,
            // não meche nele...
            if($configuration->ignore())
                break;

            // Verifica se a propriedade tem um alias e busca
            // o valor na array
            if($configuration->hasAlias())
            {
                $alias = $configuration->getAlias();

                if(array_key_exists($alias, $array))
                    $value = $array[$alias];
            }

            // Caso não tenha nenhum alias, o script irá procurar
            // por um valor relacionado com o nome original da propriedade.
            else
            {
                $alias = $configuration->getName();

                if(array_key_exists($alias, $array))
                    $value = $array[$alias];
            }

            $property->setValue($object, $value);
        }

        // Verifica se existe o método que trata os
        // valores após eles terem sido populados.
        // Se tiver, o executa.
        if(method_exists($object, 'afterPopulate'))
        {
            call_user_func('afterPopulate', $object, [$array]);
        }
    }
}