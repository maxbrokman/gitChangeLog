<?php

namespace MaxBrokman\GitChangeLog\Tests;

use MaxBrokman\GitChangeLog\Git;

class GitTest extends \PHPUnit_Framework_TestCase {

    public function testGetTags()
    {
        $git = new Git;
        $tags = $git->getTags();

        $this->assertTrue(is_array($tags), "Tags should be returned as an array");
    }

    public function testGetLog()
    {
        $git = new Git;
        $log = $git->getLog("v0.0.1");

        $this->assertTrue(is_array($log), "Log should be returned as an array");
    }

    public function testGetDate()
    {
        $git = new Git;
        $git->getDate("v0.0.1");
    }
}
 