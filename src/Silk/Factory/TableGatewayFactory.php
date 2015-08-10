<?php

namespace Silk\Factory;

use PhpDocReader\Reader;
use Silk\Exception\TableNotFoundException;
use Silk\Model\MappableModelInterface;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\Db\TableGateway\TableGateway;

/**
 * Class TableGatewayFactory
 * @author  Lucas A. de Araújo <lucas@painapp.com.br>
 * @package Silk\Factory
 */
class TableGatewayFactory
{
    /**
     * @param MappableModelInterface $object
     * @return TableGateway
     * @throws TableNotFoundException
     */
    public static function create(MappableModelInterface $object)
    {
        $config = (new Reader())->getConfig($object);

        if(!array_key_exists('table', $config))
            throw new TableNotFoundException();

        $tableGateway = new TableGateway();
        $tableGateway->table = (new Reader())->getConfig($object)['table'];
        $tableGateway->adapter = GlobalAdapterFeature::getStaticAdapter();

        return $tableGateway;
    }
}