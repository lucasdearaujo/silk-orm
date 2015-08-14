<?php

namespace Silk\Configuration;

/**
 * Class ClassConfiguration
 * @author  Lucas A. de Araújo <lucas@painapp.com.br>
 * @package Silk\Configuration
 */
class ClassConfiguration
{
    /**
     * @var string
     */
    private $table;

    /**
     * @var string
     */
    private $primaryKey;

    /**
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @param string $table
     */
    public function setTable($table)
    {
        $this->table = $table;
    }

    /**
     * @return string
     */
    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }

    /**
     * @param string $primaryKey
     */
    public function setPrimaryKey($primaryKey)
    {
        $this->primaryKey = $primaryKey;
    }
}