<?php
/**
 * File to print the native serialized variables
 *
 * @author Christopher Marchfelder <marchfelder@googlemail.com>
 */
function s($variable)
{
    // @todo there is a some sort of utf8 character which prevents the printf
    // from printing
    printf("%s\n", serialize($variable));
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