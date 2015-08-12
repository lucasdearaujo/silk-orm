<?php

namespace Silk\Exception;

/**
 * Class TableNotFoundException
 * @author  Lucas A. de Araújo <lucas@painapp.com.br>
 * @package Silk\Exception
 */
class TableNotFoundException extends \Exception
{
    public function __construct(){
        $this->message = "We could not found the table name in your mappable object,
        please, use @configure {\"table\":\"mytablename\"}";
    }
}