<?php

use PHPUnit\Framework\TestCase;
use Rachel\Entry;

final class EntryTest extends TestCase
{
    public function testConstructNoArg()
    {
        $entry = new Entry();
        $this->assertEquals('', $entry->getName());
        $this->assertEquals('', $entry->getUrl());
    }

    public function testConstructNoNameOrUrl()
    {
        $entry = new Entry(['feeling' => 'lucky']);
        $this->assertEquals('', $entry->getName());
        $this->assertEquals('', $entry->getUrl());
    }

    public function testConstructNormal()
    {
        $entry = new Entry(['name' => 'happy', 'url' => 'golucky']);
        $this->assertEquals('happy', $entry->getName());
        $this->assertEquals('golucky', $entry->getUrl());
    }

    public function testCastToString()
    {
        $entry = new Entry(['name' => 'happy', 'url' => 'golucky']);
        $expected = "happy [golucky]";
        $actual = (string) $entry;
        $this->assertEquals($expected, $actual);
    }
}
