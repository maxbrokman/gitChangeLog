<?php


namespace MaxBrokman\GitChangeLog\Tests;

use MaxBrokman\GitChangeLog\ChangeLogEntry;

class ChangeLogEntryTest extends \PHPUnit_Framework_TestCase {

    /**
     * @covers MaxBrokman\GitChangeLog\ChangeLogEntry::__construct
     * @covers MaxBrokman\GitChangeLog\ChangeLogEntry::__get
     * @covers MaxBrokman\GitChangeLog\ChangeLogEntry::__isset
     * @covers MaxBrokman\GitChangeLog\ChangeLogEntry::fill
     */
    public function testFillsOnConstruct()
    {
        $entry = new ChangeLogEntry([
            'foo' => 'bar'
        ]);

        $this->assertTrue(isset($entry->foo), "Foo should be marked as isset");
        $this->assertSame('bar', $entry->foo);
    }

    /**
     * @covers MaxBrokman\GitChangeLog\ChangeLogEntry::fill
     * @covers MaxBrokman\GitChangeLog\ChangeLogEntry::__get
     */
    public function testFill()
    {
        $entry = new ChangeLogEntry;
        $entry->fill([
            'foo' => 'bar'
        ]);

        $this->assertSame('bar', $entry->foo);
    }

    /**
     * @covers MaxBrokman\GitChangeLog\ChangeLogEntry::__get
     */
    public function testNullWhenNoAttribute()
    {
        $entry = new ChangeLogEntry;

        $this->assertTrue(is_null($entry->foo), "Change log should return null when attributes not set");
    }
}
 