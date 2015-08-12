<?php

namespace Silk\Model;
use PhpDocReader\Reader;
use Silk\Exchanger\OExchanger;
use Silk\Factory\TableGatewayFactory;

/**
 * Class AbstractMappableModel
 * @author  Lucas A. de Araújo <lucas@painapp.com.br>
 * @package Silk\Model
 */
abstract class AbstractMappableModel implements MappableModelInterface
{
    /**
     * @configure {"ignore":true}
     * @var \Zend\Db\TableGateway\TableGateway
     */
    private $tableGateway;

    /**
     * @configure {"ignore":true}
     * @var int
     */
    private $primaryKey;

    /**
     * Construtor
     */
    public function __construct()
    {
        $this->tableGateway = TableGatewayFactory::create(get_called_class());
        $this->primaryKey = (new Reader())->getConfig(get_called_class())['primary_key'];
    }

    /**
     * Insere um novo registro no banco, ou atualiza se
     * ja for existente.
     * @return int
     */
    public function save()
    {
        $array = OExchanger::toArray($this);

        if(empty($this->getId())) {
            $result = $this->tableGateway->insert($array);
            $this->setId($this->tableGateway->lastInsertValue);
            return $result;
        }
        else
        {
            $where = [$this->primaryKey => $this->getId()];
            $result = $this->tableGateway->update($array, $where);
            return $result;
        }
    }

    /**
     * Remove um registro do banco de dados.
     * @return int
     */
    public function delete()
    {
        // TODO: Implement delete() method.
    }

    /**
     * Seleciona uma coleção de dados,
     * @param $where
     */
    public static function select($where)
    {
        // TODO: Implement select() method.
    }
}