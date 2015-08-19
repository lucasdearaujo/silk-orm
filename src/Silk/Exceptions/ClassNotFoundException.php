<?php

namespace Silk\Exceptions;

/**
 * Class NoDataFoundException
 * @author  Lucas A. de Araújo <lucas@painapp.com.br>
 * @package Silk\Exceptions
 */
class ClassNotFoundException extends \Exception
{
    protected $message = "A classe informada para instanciamento não foi encontrada";
}