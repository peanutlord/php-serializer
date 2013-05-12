<?php
require 'Serializer.php';

/**
 * File to measure the speed (which should be slow)
 */
/**
 * Empty class for test case
 */
class EmptyCls { }

/**
 * Plain class for test case
 */
class PlainCls
{
    protected $_1stVariable = "I am first!";
}

/**
 * A little bit more complex class with nested classes
 */
class ComplexClass
{
    protected $_emptyCls = null;

    protected $_plainCls = null;

    public function __construct()
    {
        $this->_emptyCls = new EmptyCls();
        $this->_plainCls = new PlainCls();
    }
}

/**
 * Prints given input
 *
 * @param string $input
 * @return void
 */
function p($input)
{
    print $input."\n";
}

/**
 * Wrapper for the native serialization function
 *
 * @param mixed $object
 * @return void
 */
function nativeSerialize($object)
{
    $start = microtime();
    serialize($object);
    $diff = microtime() - $start;

    p(sprintf("Native serializing %s took: %f", get_class($object), $diff));
}

/**
 * Wrapper for the PHP serializer
 *
 * @param mixed $object
 * @return void
 */
function phpSerialize($object)
{
    $s = new Serializer();

    $start = microtime();
    $s->serialize($object);
    $diff = microtime() - $start;

    p(sprintf("PHP serializing %s took: %f", get_class($object), $diff));
}

nativeSerialize(new EmptyCls());
nativeSerialize(new PlainCls());
nativeSerialize(new ComplexClass());

phpSerialize(new EmptyCls());
phpSerialize(new PlainCls());
phpSerialize(new ComplexClass());