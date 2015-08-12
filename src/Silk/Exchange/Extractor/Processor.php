<?php

namespace Silk\Exchange\Extractor;
use Silk\Model\MappableModelInterface;

/**
 * Class Processor
 * @author  Lucas A. de Araújo <lucas@painapp.com.br>
 * @package Silk\Exchange\Extractor
 */
class Processor
{

    private $data;

    /**
     * @param $property
     * @return bool
     */
    private function processProperty($property)
    {
        $name = $property['name'];
        $data = $property['data'];

        // Ignora a propriedade
        // {"ignore":true}
        if(array_key_exists('ignore', $property['config']))
            return false;

        // Ignora a propriedade se o valor for vazio
        // {"ignoreIfNull":true}
        if(array_key_exists('ignoreIfNull', $property['config'])){
            if(empty($property['data']))
                return false;
        }

        // Define uma alias para a propriedade
        // {"alias":"nome_da_coluna"}
        if(array_key_exists('alias', $property['config'])) {
            $name = $property['config']['alias'];
        }

        // Captura a id do objeto
        if($data instanceof MappableModelInterface){
            $data = $data->getId();
        }

        $this->data[$name] = $data;
    }

    /**
     * @param $array
     */
    public function process($array)
    {
        foreach($array as $property)
            self::processProperty($property);

        return $this->data;
    }
}