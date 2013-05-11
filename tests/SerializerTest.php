<?php
require_once 'src/Serializer.php';
require_once 'PHPUnit/Framework/TestCase.php';

/**
 * Empty class for test case
 */
class EmptyCls { }

/**
 * Serializer test case.
 */
class SerializerTest extends PHPUnit_Framework_TestCase
{

    /**
     * Holds the serializer
     *
     * @var Serializer
     */
    protected $_serializer = null;

    /**
     * Holds a reflection object of the serializer
     *
     * @var ReflectionObject
     */
    protected $_reflectedSerializer = null;

    /**
     * Creates the serializer objects for usage in test cases
     */
    public function __construct()
    {
        $this->_serializer          = new Serializer();
        $this->_reflectedSerializer = new ReflectionObject($this->_serializer);
    }

    /**
     * Method to invoke protected/private in the Serializer class
     *
     * @return mixed
     */
    protected function _invoke()
    {
        $args         = func_get_args();
        $calledMethod = array_shift($args);

        /* @var $method ReflectionMethod */
        $method = $this->_reflectedSerializer->getMethod($calledMethod);
        if (!$method->isPublic()) {
            $method->setAccessible(true);
        }

        return $method->invokeArgs($this->_serializer, $args);
    }

    /**
     *
     */
    public function testSerializeInt()
    {
        $this->assertEquals(serialize(0), $this->_invoke('_serializeInt', 0));
        $this->assertEquals(serialize(1), $this->_invoke('_serializeInt', 1));
        $this->assertEquals(serialize(-1), $this->_invoke('_serializeInt', -1));
    }

    /**
     *
     */
    public function testSerializeBool()
    {
        $this->assertEquals(serialize(true), $this->_invoke('_serializeBool', true));
        $this->assertEquals(serialize(false), $this->_invoke('_serializeBool', false));
    }

    /**
     *
     */
    public function testSerializeString()
    {
        $this->assertEquals(serialize("Hello World"), $this->_invoke("_serializeString", "Hello World"));
    }

    /**
     *
     */
    public function testSerializeArray()
    {
        $array = array('foo' => 'bar');
        $this->assertEquals(serialize($array), $this->_invoke("_serializeArray", $array));

        $array = array('foo' => array('bar' => 'baz', '123' => 'qwe'));
        $this->assertEquals(serialize($array), $this->_invoke("_serializeArray", $array));
    }

    /**
     *
     */
    public function testSerializeEmptyObject()
    {
        $this->assertEquals(serialize(new EmptyCls()), $this->_invoke('_serializeObject', new EmptyCls()));
    }
}
