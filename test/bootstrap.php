<?php

// Composer autoload
include "../vendor/autoload.php";

// Dependências
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\Db\Adapter\Adapter;

// Configuração do banco de dados
GlobalAdapterFeature::setStaticAdapter(
    new Adapter(array(
            'driver'   => 'Mysqli',
            'hostname' => 'localhost',
            'database' => 'silk',
            'username' => 'root',
            'password' => null,
            'charset'  => 'utf8',
            'options'  => array('buffer_results' => true)
        )
    ));