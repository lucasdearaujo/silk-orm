<?php

namespace Silk\Mapping;

use PhpDocReader\Reader;
use Silk\Model\MappableModelInterface;

/**
 * Class ObjectMapper
 * @author  Lucas A. de Araújo <lucas@painapp.com.br>
 * @package Silk\Mapping
 */
class ObjectMapper
{
    /**
     * @var object
     */
    private $object;

    /**
     * Retorna o objeto do mapeador
     * @return object
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * Define o objeto do mapeador
     * @param object $object
     */
    public function setObject($object)
    {
        $this->object = $object;
    }

    /**
     * Retorna o nome de um elemento, levando em consideração
     * caso ele contenha um alias.
     * @param \ReflectionProperty $property
     * @return string
     */
    public function getPropertyName(\ReflectionProperty $property)
    {
        $class = $property->getDeclaringClass()->getName();
        $variable = $property->getName();

        $reader = new Reader();
        $config = $reader->getConfig($class, $variable);

        if(isset($config['alias']))
        {
            return $config['alias'];
        }
        else
        {
            return $property->getName();
        }
    }

    /**
     * Faz o tratemento padrão para salvar os dados.
     * @param \ReflectionProperty $property
     * @return int
     */
    public function getPropertyData(\ReflectionProperty $property)
    {

        $property->setAccessible(true);

        $data = $property->getValue($this->getObject());

        if($data instanceof MappableModelInterface)
        {
            return $data->getId();
        }
        else if(is_object($data))
        {
            return (string) $data;
        }
    }

    /**
     * Verifica se a propriedade deve ser ignorada no mapeamento.
     * @param \ReflectionProperty $property
     * @return bool
     */
    public function ignoreProperty(\ReflectionProperty $property)
    {
        $reader = new Reader();
        $config = $reader->getConfig($this->getObject(), $property->getName());

        if(isset($config['ignore']) && $config['ignore'] === true)
        {
            return true;
        }
        else
        {
            return false;
        }

    }

    /**
     * Retorna o objeto como uma array
     * @return array
     */
    public function toArray()
    {
        $array = [];
        $reflection = new \ReflectionClass($this->getObject());

        // Verifica todas as propriedades do objeto
        // (todas variáveis da classe)
        foreach($reflection->getProperties() as $property)
        {
            if(!$this->ignoreProperty($property))
            {
                $name = $this->getPropertyName($property);
                $data = $this->getPropertyData($property);
                $array[$name] = $data;
            }
        }

        return $array;
    }
}