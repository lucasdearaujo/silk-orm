<?php

namespace Silk\Exceptions;

/**
 * Class NoPrimaryKeyException
 * @author  Lucas A. de Araújo <lucas@painapp.com.br>
 */
class NoPrimaryKeyException extends \Exception
{
    protected $message = "Não foi definida nenhuma chave primária para seu objeto. ".
                       "Faça a pesquisa passando um where ao invés de um valor numérico inteiro ".
                       "no parâmetro do construtor de seu objeto.";
}