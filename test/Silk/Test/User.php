<?php

namespace Silk\Test;

use Silk\Exceptions\NoDataFoundException;
use Silk\Model\AbstractMappableModel;

/**
 * Class User
 * @author  Lucas A. de Araújo <lucas@painapp.com.br>
 * @package Silk\Test
 * @configure {"table":"cad_user"}
 * @configure {"primary_key":"iduser"}
 */
class User extends AbstractMappableModel
{
    /**
     * @var int
     * @configure {"ignoreIfNull":true}
     */
    private $iduser;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @configure {"alias":"idcompany"}
     * @var Company
     */
    private $company;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->iduser;
    }

    /**
     *
     * @param $id
     */
    public function setId($id)
    {
        $this->iduser = $id;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return Company
     */
    public function getCompany()
    {
        try
        {
            $this->company = new Company($this->company);

        }
        catch(NoDataFoundException $e)
        {
            $this->company = new Company();
        }
        finally
        {
            return $this->company;
        }
    }

    /**
     * @param Company $company
     */
    public function setCompany($company)
    {
        $this->company = $company;
    }
}