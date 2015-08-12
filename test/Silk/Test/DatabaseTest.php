<?php

namespace Silk\Test;
use Zend\Db\Sql\Select;

/**
 * Class DatabaseTest
 *
 * @author  Lucas A. de Araújo <lucas@painapp.com.br>
 * @package Silk\Test
 */
class DatabaseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Testa os métodos de inserção, seleção, edição e exclusão,
     * nessa respectiva ordem mencionada.
     *
     * @expectedException \Silk\Exceptions\NoDataFoundException
     */
    public function testCrud()
    {
        $user = new User();
        $user->setUsername('lucas');
        $user->setPassword('12345');
        $user->save();

        $user = new User($user->getId());
        $user->setUsername('milena');
        $user->setPassword('123456');
        $user->save();

        $user = new User(function(Select $select){
            $select->where->equalTo('username', 'milena');
            $select->where->equalTo('password', '123456');
        });

        $user->delete();

        // Lança uma exception Silk\Exceptions\NoDataFoundException
        new User(function(Select $select){
            $select->where->equalTo('username', 'milena');
            $select->where->equalTo('password', '123456');
        });
    }

    public function testMultipleDataSelection()
    {

    }
}