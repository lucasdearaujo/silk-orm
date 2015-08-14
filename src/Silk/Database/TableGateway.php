<?php

namespace Silk\Database;

use PhpDocReader\Reader;
use Silk\Exceptions\NoTableFoundException;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;

/**
 * Class TableGateway
 * @author  Lucas A. de Araújo <lucas@painapp.com.br>
 * @package Silk\Database
 */
class TableGateway extends AbstractTableGateway
{
    public function __construct($object)
    {
        $config = Reader::getConfig($object);

        if (!array_key_exists('table', $config))
            throw new NoTableFoundException();

        $this->table = $config['table'];
        $this->adapter = GlobalAdapterFeature::getStaticAdapter();
    }
}