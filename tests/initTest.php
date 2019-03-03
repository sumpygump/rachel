<?php

use PHPUnit\Framework\TestCase;
use Rachel\Catalog;

final class InitTest extends TestCase
{
    public function testInit()
    {
        $init = require "../init.php";

        $this->assertInstanceOf(Catalog::class, $init['catalog']);
    }
}
