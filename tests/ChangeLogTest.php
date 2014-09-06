<?php


namespace MaxBrokman\GitChangeLog\Tests;

use MaxBrokman\GitChangeLog\ChangeLog;
use \Mockery as M;

class ChangeLogTest extends \PHPUnit_Framework_TestCase {

    public function testGetChangeLog()
    {
        $gitMock = M::mock('MaxBrokman\GitChangeLog\Git')
            ->shouldReceive('getTags')
            ->andReturn($this->tagList())
            ->shouldReceive('getLog')
            ->andReturn($this->log())
            ->shouldReceive('getDate')
            ->andReturn(time())
            ->getMock();

        $changeLog = new ChangeLog($gitMock);
        $changeLog->setPerPage(2);
        $log = $changeLog->getChangeLog();

        $this->assertTrue(is_array($log), "Change log should be returned as array");
        $this->assertTrue(count($log) === 2, "Change log should have 2 items with mocked data");
        $this->assertTrue(is_array($log[0]->changesSinceLastTag), "Log items should have array of changes.");
        $this->assertTrue(count($log[0]->changesSinceLastTag) === 2, "Changes since last tag should have 2 items with mocked data");
        $this->assertTrue(isset($log[0]->tag), "Change log entry should have a tag");
        $this->assertTrue(isset($log[0]->date), "Change log entry should have a date");

    }

    private function tagList()
    {
        return [
            "v0.0.1",
            "v0.0.2",
            "v0.0.3",
            "v0.0.4",
            "v0.0.5",
            "v0.0.6"
        ];
    }

    private function log()
    {
        return [
            (object) [
                "commit" => "aaaaaa",
                "author" => "Max Brokman <max.brokman@gmail.com>",
                "date" => "4 months ago",
                "message" => "Commit Message @public"
            ],
            (object) [
                "commit" => "aaaaaa",
                "author" => "Max Brokman <max.brokman@gmail.com>",
                "date" => "5 months ago",
                "message" => "Commit Message 2 @public"
            ]
        ];
    }
}
 