<?php

namespace Silk\Exceptions;

/**
 * Class NoDataFoundException
 * @author  Lucas A. de Araújo <lucas@painapp.com.br>
 * @package Silk\Exceptions
 */
class NoTableFoundException extends \Exception
{
    protected $message = "Você não configurou nenhuma tabela no banco de dados que ".
                       "corresponda com o seu objeto mapeável.";
}