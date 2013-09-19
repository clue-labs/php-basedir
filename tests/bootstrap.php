<?php

require __DIR__ . '/../vendor/autoload.php';

class TestCase extends PHPUnit_Framework_TestCase
{
    protected function assertString($value)
    {
        return $this->assertInternalType('string', $value);
    }

    protected function assertArray($value)
    {
        return $this->assertInternalType('array', $value);
    }
}
