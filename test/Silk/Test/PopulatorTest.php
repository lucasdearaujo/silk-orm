<?php

namespace Silk\Test;
use Silk\Exchange\Populator\Populator;

/**
 * Class Model
 * @author  Lucas A. de Araújo <lucas@painapp.com.br>
 * @package Silk\Test
 * @configure {"table":"cad_model"}
 * @configure {"primary_key":"idmodel"}
 */
class NewModel
{
    /**
     * @configure {"alias":"elemento"}
     */
    private $element = 1;

    /**
     * @configure {"ignoreIfNull":true}
     */
    private $ignored = null;

    /**
     * @configure {"ignoreIfNull":true}
     */
    private $notIgnored = 123;

    /**
     * @return mixed
     */
    public function getElement()
    {
        return $this->element;
    }

    /**
     * @param mixed $element
     */
    public function setElement($element)
    {
        $this->element = $element;
    }

    /**
     * @return mixed
     */
    public function getIgnored()
    {
        return $this->ignored;
    }

    /**
     * @param mixed $ignored
     */
    public function setIgnored($ignored)
    {
        $this->ignored = $ignored;
    }

    /**
     * @return mixed
     */
    public function getNotIgnored()
    {
        return $this->notIgnored;
    }

    /**
     * @param mixed $notIgnored
     */
    public function setNotIgnored($notIgnored)
    {
        $this->notIgnored = $notIgnored;
    }
}


class PopulatorTest extends \PHPUnit_Framework_TestCase
{
    public function testPopulation()
    {
        $model = new NewModel();
        $array = ['elemento' => 2, 'notIgnored' => 321];
        Populator::populate($model, $array);

        $this->assertEquals($array['elemento'], $model->getElement());
        $this->assertEquals($array['notIgnored'], $model->getNotIgnored());
    }
}