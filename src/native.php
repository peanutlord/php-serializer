<?php
/**
 * File to print the native serialized variables
 *
 * @author Christopher Marchfelder <marchfelder@googlemail.com>
 */
function s($variable)
{
    // @todo why does serialize add the \0?
    $s = serialize($variable);
    $s = str_replace("\0", '', $s);

    printf("%s\n", $s);
}

s(1);
s(-1);
s(0);

s(0.0);
s(1.0);
s(-1.0);
S(3.14);

s("Hello World");

s(true);
s(false);

s(array('foo' => 'bar'));
s(array('foo' => array('bar' => 'baz', '123' => 'qwe')));

class EmptyCls { }
s(new EmptyCls());

class PlainCls
{
    protected $_1stVariable = "I am first!";
}
s(new PlainCls());