<?php
/**
 * File to print the native serialized variables
 *
 * @author Christopher Marchfelder <marchfelder@googlemail.com>
 */
function s($variable)
{
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