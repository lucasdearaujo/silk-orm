<?php

namespace Silk\Model;

use Collections\ArrayList;
use PhpDocReader\Reader;
use Silk\Database\TableGateway;
use Silk\Exceptions\NoDataFoundException;
use Silk\Exceptions\NoPrimaryKeyException;
use Silk\Exchange\Extractor\Extractor;
use Silk\Exchange\Populator\Populator;
use Zend\Db\Sql\Select;

/**
 * Class AbstractMappableModel
 * @author  Lucas A. de Araújo <lucas@painapp.com.br>
 * @package Silk\Model
 */
abstract class AbstractMappableModel implements MappableModelInterface
{
    /**
     * @var TableGateway
     * @configure {"ignore":true}
     */
    private $tableGateway;

    /**
     * @var string
     * @configure {"ignore":true}
     */
    private $primaryKey = null;

    /**
     * Verifica qual a estratégia de população adequada de
     * acordo com o parâmetro passado pelo usuário, e também
     * inicia as dependências da classe, bem como a definição
     * de seu TableGateway.
     *
     * @param null $param
     * @throws NoDataFoundException
     * @throws NoPrimaryKeyException
     */
    public function __construct($param = null)
    {
        // Define a chave primária do objeto
        $this->primaryKey = Reader::getConfig($this)['primary_key'];

        // Constrói o objeto de acesso aos dados.
        $this->tableGateway = new TableGateway($this);

        // Se for numérico ou string, presume-se
        // que é uma chave primária.
        if(is_numeric($param) || is_string($param))
        {
            $this->populateFromId($param);
        }

        // Verifica se é um comando do tipo where
        // que pode ser usado diretamente como parâmetro
        // no TableGateway do Zend Framework 2.
        else if(is_array($param) || is_callable($param) || $param instanceof Select)
        {
            $this->populateFromWhere($param);
        }
    }

    /**
     * Método responsável por construir o where responsável
     * por fazer a busca dos dados do objeto no banco através
     * de sua chave primária, previamente configurada na classe.
     *
     * @param $id
     * @throws NoDataFoundException
     * @throws NoPrimaryKeyException
     */
    private function populateFromId($id)
    {
        if(empty($this->primaryKey))
            throw new NoPrimaryKeyException();

        $this->populateFromWhere([$this->primaryKey => $id]);
    }

    /**
     * Popula o objeto a partir de um comando where. Ou
     * lança uma exception caso nenhum tipo de dado tenha
     * sido encontrado no banco de dados, a modo de corresponder
     * com a busca.
     *
     * @param $where
     * @throws NoDataFoundException
     */
    private function populateFromWhere($where)
    {
        $resultSet = $this->tableGateway->select($where);

        if($resultSet->count() == 0)
            throw new NoDataFoundException();

        $array = $resultSet->toArray()[0];
        Populator::populate($this, $array);
    }

    /**
     * Método responsável por salvar um objeto no banco de dados
     * verificando qual é a estratégia ideal. Se o objeto tiver
     * uma chave primária definida, ele será atualizado, caso não
     * houve nenhuma, será inserido um novo registro no banco.
     *
     * @return int
     */
    public function save()
    {
        if(empty($this->getId()))
        {
            return $this->insert();
        }
        else
        {
            return $this->update();
        }
    }

    /**
     * Seleciona uma coleção de objetos do tipo do objeto que fora
     * chamado. O método irá identificar qual a classe filho dessa
     * classe atual, e instanciar um objeto do tipo da classe filho
     * e em seguida popular ele e adicioná-lo na lista de dados.
     *
     * @param $where
     * @return ArrayList
     * @throws NoDataFoundException
     */
    public static function select($where)
    {
        $table = new TableGateway(self::getInstance());
        $resultSet = $table->select($where);

        if($resultSet->count() == 0)
            throw new NoDataFoundException();

        $list = new ArrayList();

        foreach($resultSet->toArray() as $array)
        {
            $obj = self::getInstance();
            Populator::populate($obj, $array);
            $list->add($obj);
        }

        return $list;
    }

    /**
     * Insere um registro no banco de dados usando o método insert
     * do TableGateway do Zend Framework 2. O processo de inserção
     * é executado apenas depois de os dados dos objeto serem adequadamente
     * extraídos levando em consideração as configurações disponíveis.
     *
     * @return int
     */
    private function insert()
    {
        $result = $this->tableGateway->insert(Extractor::extract($this));
        $this->setId($this->tableGateway->lastInsertValue);
        return $result;
    }

    /**
     * Atualiza um registro no banco de dados usando o método update
     * do TableGateway do Zend Framework 2. O processo de atualização
     * é executado apenas depois de os dados dos objeto serem adequadamente
     * extraídos levando em consideração as configurações disponíveis.
     *
     * @return int
     */
    private function update()
    {
        return $this->tableGateway->update(Extractor::extract($this), [
            $this->primaryKey => $this->getId()
        ]);
    }

    /**
     * Remove um objeto do banco de dados através de sua chave primária.
     * Caso a sua chave primária não exista, o objeto do banco de dados
     * será excluído tendo como where, toda sua estrutura.
     *
     * @return int
     */
    public function delete()
    {
        if(!empty($this->primaryKey))
        {
            return $this->tableGateway->delete([$this->primaryKey => $this->getId()]);
        }
        else
        {
            return $this->tableGateway->delete(Extractor::extract($this));
        }

    }

    /**
     * Retorna uma instância da classe que chamou o método.
     *
     * @return MappableModelInterface
     */
    private static function getInstance()
    {
        $name = get_called_class();
        $object = new $name;
        return $object;
    }
}