<?php

use PHPUnit\Framework\TestCase;
use Rachel\Catalog;

final class CatalogTest extends TestCase
{
    public function tearDown()
    {
        @unlink("example.json");
    }

    public function testConstructNoArg()
    {
        $catalog = new Catalog();
        $this->assertEquals([], $catalog->getEntries());
    }

    public function testConstructWithInvalidFile()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("File 'nofile.txt' not found");
        $catalog = new Catalog('nofile.txt');
    }

    public function testConstructCannotDecodeFile()
    {
        file_put_contents("example.json", "xyz");
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("not a valid catalog json");
        $catalog = new Catalog('example.json');
    }

    public function testConstructNonArrayJson()
    {
        file_put_contents("example.json", '{"strawberry":"fields forever"}');
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("not a valid catalog json");
        $catalog = new Catalog('example.json');
    }

    public function testConstructArrayJson()
    {
        file_put_contents("example.json", '[1]');
        $catalog = new Catalog('example.json');
        $this->assertEquals([], $catalog->getEntries());
    }

    public function testPopulate()
    {
        $json = json_decode('[{"a":"b"},{"x":"y"}]');
        $catalog = new Catalog();
        $catalog->populate($json);

        $this->assertEquals([], $catalog->getEntries());
    }

    public function testPopulateOneWithNameNoUrl()
    {
        $json = json_decode('[{"name":"one"}]');
        $catalog = new Catalog();
        $catalog->populate($json);

        $this->assertEquals([], $catalog->getEntries());
    }

    public function testPopulateOneWithUrlNoName()
    {
        $json = json_decode('[{"url":"https://rad"}]');
        $catalog = new Catalog();
        $catalog->populate($json);

        $this->assertEquals([], $catalog->getEntries());
    }

    public function testPopulateOneFull()
    {
        $json = json_decode('[{"name":"one","url":"https://rad"}]');
        $catalog = new Catalog();
        $catalog->populate($json);

        $this->assertEquals(1, count($catalog->getEntries()));
    }

    public function testGetByIndex()
    {
        $json = json_decode('[{"name":"one","url":"https://rad"}]');
        $catalog = new Catalog();
        $catalog->populate($json);

        // If there is only one entry, they are all the same
        $entry = $catalog->getByIndex(0);
        $this->assertEquals($entry->getName(), "one");
        $this->assertEquals($entry->getUrl(), "https://rad");

        $entry = $catalog->getByIndex(1);
        $this->assertEquals($entry->getName(), "one");
        $this->assertEquals($entry->getUrl(), "https://rad");

        $entry = $catalog->getByIndex(1000);
        $this->assertEquals($entry->getName(), "one");
        $this->assertEquals($entry->getUrl(), "https://rad");
    }

    public function testGetByIndexTwo()
    {
        $json = json_decode('[{"name":"one","url":"https://rad"}, {"name":"two","url":"https://glad"}]');
        $catalog = new Catalog();
        $catalog->populate($json);

        // If there are two entries, they flipflop
        $entry = $catalog->getByIndex(0);
        $this->assertEquals($entry->getName(), "one");
        $this->assertEquals($entry->getUrl(), "https://rad");

        $entry = $catalog->getByIndex(1);
        $this->assertEquals($entry->getName(), "two");
        $this->assertEquals($entry->getUrl(), "https://glad");

        $entry = $catalog->getByIndex(1000);
        $this->assertEquals($entry->getName(), "one");
        $this->assertEquals($entry->getUrl(), "https://rad");
    }

    public function testGetForDate()
    {
        $json = json_decode('[{"name":"one","url":"https://rad"}, {"name":"two","url":"https://glad"}, {"name":"three","url":"https://sad"}]');
        $catalog = new Catalog();
        $catalog->populate($json);

        $entry = $catalog->getForDate('2001-01-01');
        $this->assertEquals($entry->getName(), "one");
        $this->assertEquals($entry->getUrl(), "https://rad");

        $entry = $catalog->getForDate('2001-01-03');
        $this->assertEquals($entry->getName(), "three");
        $this->assertEquals($entry->getUrl(), "https://sad");
    }

    public function testGetDayIndexForDateString()
    {
        $catalog = new Catalog();

        $index = $catalog->getDayIndexForDate('2011-01-01');

        // ten years later, and two leap years in there, makes it
        // day number 3,652
        $this->assertEquals(3652, $index);
    }

    public function testGetDayIndexForDateWithTime()
    {
        $catalog = new Catalog();

        $index = $catalog->getDayIndexForDate('2011-01-01 16:42:09');

        // ten years later, and two leap years in there, makes it
        // day number 3,652 - round down to integer
        $this->assertEquals(3652, $index);
    }

    public function testGetDayIndexForDateWithTimeJustBeforeMidnight()
    {
        $catalog = new Catalog();

        $index = $catalog->getDayIndexForDate('2011-01-01 23:59:59');

        // This still counts as that day
        $this->assertEquals(3652, $index);
    }

    public function testGetDayIndexForDateNow()
    {
        $catalog = new Catalog();

        $now = time();
        $epoch = strtotime('2001-01-01');
        $days_since = floor(($now - $epoch) / 86400);

        $index = $catalog->getDayIndexForDate();
        $this->assertEquals($days_since, $index);
    }
}
