<?php

namespace Silk\Test;

use Silk\Model\AbstractMappableModel;

/**
 * Class RandomObject
 * @author  Lucas A. de Araújo <lucas@painapp.com.br>
 * @package Silk\Test
 * @configure {"table":"cad_car"}
 * @configure {"primary_key":"idcar"}
 */
class RandomObject extends AbstractMappableModel
{
    /**
     * @var int
     * @configure {"alias":"idcarro"}
     */
    private $idcar;

    /**
     * @var \DateTime
     * @configure {"ignore":true}
     */
    private $fabricacao;

    /**
     * Retorna a ID da chave primária de um objeto mapeável
     * @return int
     */
    public function getId()
    {
        return $this->idcar;
    }

    /**
     * Define a id de um objeto mapeável
     * @param int $id
     */
    public function setId($id)
    {
        $this->idcar = $id;
    }
}