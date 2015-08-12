<?php

namespace Silk\Test;

use Silk\Exchange\Extractor\Extractor;

/**
 * Class Model
 * @author  Lucas A. de Araújo <lucas@painapp.com.br>
 * @package Silk\Test
 * @configure {"table":"cad_model"}
 * @configure {"primary_key":"idmodel"}
 */
class Model
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
}

/**
 * Class ExtractorTest
 * @author  Lucas A. de Araújo <lucas@painapp.com.br>
 * @package Silk\Test
 */
class ExtractorTest extends \PHPUnit_Framework_TestCase
{
    public function testExtraction()
    {
        $object = new Model();
        $array = Extractor::extract($object);

        $this->assertFalse(array_key_exists('ignored', $array));
        $this->assertTrue(array_key_exists('elemento', $array));
        $this->assertTrue(array_key_exists('notIgnored', $array));
    }
}