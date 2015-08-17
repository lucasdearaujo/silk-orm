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
        // Cadastra uma nova compania
        $company = new Company();
        $company->setName("Softwerk");
        $company->save();

        // Cadastra um novo usuário
        $user = new User();
        $user->setUsername('lucas');
        $user->setPassword('12345');
        $user->setCompany($company);
        $user->save();

        // Edita o usuário anteriormente cadastrado
        $user = new User($user->getId());
        $user->setUsername('milena');
        $user->setPassword('123456');
        $user->save();

        // Seleciona usuário com select do ZF2
        $user = new User(function(Select $select){
            $select->where->equalTo('username', 'milena');
            $select->where->equalTo('password', '123456');
        });

        // Remove usuário e compania
        $user->delete();
        $company->delete();

        // Lança uma exception Silk\Exceptions\NoDataFoundException
        new User(function(Select $select){
            $select->where->equalTo('username', 'milena');
            $select->where->equalTo('password', '123456');
        });
    }

    /**
     * Testa a operação sobre mútiplos dados de forma
     * simplificada.
     *
     * @expectedException \Silk\Exceptions\NoDataFoundException
     */
    public function testMultipleDataSelection()
    {
        // Cria uma nova compania para o usuário
        $company = new Company();
        $company->setName("Softwerk");
        $company->save();

        // Insere um novo registro no banco
        $user = new User();
        $user->setUsername('lucas');
        $user->setPassword('12345');
        $user->setCompany($company);
        $user->save();

        // Insere um novo registro no banco
        $user = new User();
        $user->setUsername('lucas');
        $user->setPassword('12345');
        $user->setCompany($company);
        $user->save();

        // Insere um novo registro no banco
        $user = new User();
        $user->setUsername('lucas');
        $user->setPassword('12345');
        $user->setCompany($company);
        $user->save();

        // Seleciona todos objetos inseridos no banco
        $collection = User::select(['username' => 'lucas']);

        // Remove todos os objetos da coleção
        $collection->map(function(User $user){
            $user->delete();
        });

        // Remove a compania
        $company->delete();

        // Tenta novamente selecionar uma coleção de objetos
        // esperando que o sistema lance uma exception.
        User::select(['username' => 'lucas']);
    }

    /**
     * Mapeando um objeto com relação vazia.
     */
    public function testObjectWithEmptyRelation()
    {
        // Cria uma nova compania para o usuário
        $company = new Company();
        $company->setName("Softwerk");
        $company->save();

        // Insere um novo registro no banco
        $user = new User();
        $user->setUsername('lucas');
        $user->setPassword('12345');
        $user->setCompany($company);
        $user->save();

        // Remove a compania
        $company->delete();

        // Carrega novamente o usuário
        $user = new User($user->getId());
        $this->assertTrue(empty($user->getCompany()->getName()));

        $user->delete();
    }
}