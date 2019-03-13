<?php

use PHPUnit\Framework\TestCase;
use Rachel\Catalog;

/**
 * InitTest
 *
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
final class InitTest extends TestCase
{
    public function testInit()
    {
        $init = require "../init.php";

        $this->assertInstanceOf(Catalog::class, $init['catalog']);
    }
}
