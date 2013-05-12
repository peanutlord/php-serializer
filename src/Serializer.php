<?php
/**
 * A serializer written in PHP to serialize variables
 *
 * @author  Christopher Marchfelder <marchfelder@googlemail.com>
 * @license "Do-what-ever-you-want-license", with no guarantee
 *
 */
class Serializer
{

    /**
     * Serializes a given variable
     *
     * @todo add stack to trace self referencing classes?
     * @param mixed toSerialize
     * @return string
     */
    public function serialize($toSerialize)
    {
        $serialized = null;

        switch(gettype($toSerialize)) {
            case 'integer':
            case 'double':
                /* @todo no double atm */
                $serialized = $this->_serializeInt($toSerialize);
                break;

            case 'string':
                $serialized = $this->_serializeString($toSerialize);
                break;

            case 'boolean':
                $serialized = $this->_serializeBool($toSerialize);
                break;

            case 'array':
                $serialized = $this->_serializeArray($toSerialize);
                break;

            case 'object':
                $serialized = $this->_serializeObject($toSerialize);
                break;
        }

        return $serialized;
    }

    /**
     *
     * @param int $int
     * @return string
     */
    protected function _serializeInt($int)
    {
        return sprintf('i:%d;', $int);
    }

    /**
     *
     * @param bool $bool
     * @return string
     */
    protected function _serializeBool($bool)
    {
        if ($bool === true) {
            return 'b:1;';
        } else {
            return 'b:0;';
        }
    }

    /**
     *
     * @param string $string
     * @return string
     */
    protected function _serializeString($string)
    {
        return sprintf('s:%d:"%s";', strlen($string), $string);
    }

    /**
     *
     * @param array $array
     * @return array
     */
    protected function _serializeArray(array $array)
    {
        $chunks = array();
        foreach ($array as $key => $val) {
            $chunks[] = $this->serialize($key);
            $chunks[] = $this->serialize($val);
        }

        return sprintf('a:%d:{%s}', count($array), implode('', $chunks));
    }

    /**
     *
     * @param object $object
     * @return string
     */
    protected function _serializeObject($object)
    {
        $reflection = new ReflectionObject($object);
        $properties = $reflection->getProperties();
        $className  = $reflection->getName();
        $chunks     = array();
        $len        = strlen($className);

        /* @var $p ReflectionProperty */
        foreach($properties as $p) {
            if (!$p->isPublic()) {
                $p->setAccessible(true);
            }

            // Native serialize seems to ignore static properties
            if ($p->isStatic()) {
                continue;
            }

            $chunks[] = $this->serialize(sprintf("\0*\0%s", $p->getName()));
            $chunks[] = $this->serialize($p->getValue($object));
        }

        return sprintf('O:%d:"%s":%d:{%s}',
                        $len,
                        $className,
                        count($properties),
                        implode('', $chunks));
    }
}