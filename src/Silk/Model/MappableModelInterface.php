<?php

namespace Silk\Model;

/**
 * Interface MappableModelInterface
 * @author  Lucas A. de Araújo <lucas@painapp.com.br>
 * @package Silk\Model
 */
interface MappableModelInterface
{
    /**
     * Retorna a ID da chave primária de um objeto mapeável
     * @return int
     */
    public function getId();

    /**
     * Define a id de um objeto mapeável
     * @param int $id
     */
    public function setId($id);

    /**
     * Insere um novo registro no banco, ou atualiza se
     * ja for existente.
     * @return int
     */
    public function save();

    /**
     * Remove um registro do banco de dados.
     * @return int
     */
    public function delete();

    /**
     * Seleciona uma coleção de dados,
     * @param $where
     */
    public static function select($where);
}