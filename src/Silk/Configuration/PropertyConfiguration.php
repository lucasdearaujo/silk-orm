<?php

namespace Silk\Configuration;

use PhpDocReader\Reader;

/**
 * Class PropertyConfiguration
 *
 * Objeto responsável por armazenar as configurações de um determinado objeto,
 * de modo a permitir uma leitura simplificada de como um determinado código deve
 * operar sobre uma propriedade de acordo com os parâmetros estabelecidos.
 *
 * @author  Lucas A. de Araújo <lucas@painapp.com.br>
 * @package Silk\Configuration
 */
class PropertyConfiguration
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var mixed
     */
    private $value;

    /**
     * @var bool
     */
    private $ignore;

    /**
     * @var bool
     */
    private $ignoreIfNull;

    /**
     * @var string
     */
    private $alias;

    /**
     * Constrói uma configuração
     * @param $property
     */
    public function __construct(\ReflectionProperty $property)
    {
        $property->setAccessible(true);
        $c = $property->getDeclaringClass()->getName();
        $p = $property->getName();

        $config = Reader::getConfig($c, $p);

        $this->setName($property->getName());

        if(array_key_exists('alias', $config))
            $this->setAlias($config['alias']);

        if(array_key_exists('ignore', $config))
            $this->setIgnore($config['ignore']);

        if(array_key_exists('ignoreIfNull', $config))
            $this->setIgnoreIfNull($config['ignoreIfNull']);
    }

    /**
     * Retorna o nome da propriedade
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Define o nome da propriedade
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Retorna o parâmetro de ignorar a propriedade.
     * @return boolean
     */
    public function ignore()
    {
        return $this->ignore;
    }

    /**
     * Define o parâmetro de ignorar a propriedade
     * @param boolean $ignore
     */
    public function setIgnore($ignore)
    {
        $this->ignore = $ignore;
    }

    /**
     * Retorna o valor do parâmetro de ignorar a propriedade
     * @return boolean
     */
    public function ignoreIfNull()
    {
        return $this->ignoreIfNull;
    }

    /**
     * Define o parâmetro de ignorar a propriedade
     * @param boolean $ignoreIfNull
     */
    public function setIgnoreIfNull($ignoreIfNull)
    {
        $this->ignoreIfNull = $ignoreIfNull;
    }

    /**
     * Verifica se contém um alias na configuração
     * @return bool
     */
    public function hasAlias()
    {
        return (is_null($this->alias) === false);
    }

    /**
     * Retorna o alias da configuração
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Define o alias da configuração
     * @param string $alias
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;
    }
}