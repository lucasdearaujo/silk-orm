<?php

namespace Silk\Test;

use Silk\Model\AbstractMappableModel;

/**
 * Class Company
 * @author  Lucas A. de Araújo <lucas@painapp.com.br>
 * @package Silk\Test
 * @configure {"table":"cad_company"}
 * @configure {"primary_key":"idcompany"}
 */
class Company extends AbstractMappableModel
{
    /**
     * @var int
     */
    private $idcompany;

    /**
     * @var string
     */
    private $name;

    /**
     * Retorna a id da compania
     * @return int
     */
    public function getId()
    {
        return $this->idcompany;
    }

    /**
     * Define a id da compania
     * @param int $id
     */
    public function setId($id)
    {
        $this->idcompany = $id;
    }

    /**
     * Retorna o nome da compania
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Define o nome da compania
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}