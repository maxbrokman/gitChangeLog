<?php

namespace MaxBrokman\GitChangeLog\Tests;

use MaxBrokman\GitChangeLog\Git;

class GitTest extends \PHPUnit_Framework_TestCase {

    /**
     * @covers MaxBrokman\GitChangeLog\Git::getTags
     */
    public function testGetTags()
    {
        $git = new Git;
        $tags = $git->getTags();

        $this->assertTrue(is_array($tags), "Tags should be returned as an array");
    }

    /**
     * @covers MaxBrokman\GitChangeLog\Git::getLog
     */
    public function testGetLog()
    {
        $git = new Git;
        $log = $git->getLog("v0.0.1", "v0.0.2");

        $this->assertTrue(is_array($log), "Log should be returned as an array");
    }

    /**
     * @covers MaxBrokman\GitChangeLog\Git::getDate
     */
    public function testGetDate()
    {
        $git = new Git;
        $git->getDate("v0.0.1");
    }

    /**
     * @covers MaxBrokman\GitChangeLog\Git::getFirstCommit
     */
    public function testGetFirstCommit()
    {
        $git = new Git;
        $commit = $git->getFirstCommit();
        $this->assertTrue(is_string($commit), "Commit hash should be a string");
    }

    /**
     * @covers MaxBrokman\GitChangeLog\Git::getPreviousCommit
     */
    public function testGetPreviousCommit()
    {
        $git = new Git;
        $commit = $git->getPreviousCommit("HEAD");

        $this->assertTrue(is_string($commit), "Commit hash should be a string");
    }

    /**
     * @covers MaxBrokman\GitChangeLog\Git::getDiff
     * @covers MaxBrokman\GitChangeLog\Git::getPreviousCommit
     */
    public function testGetDiff()
    {
        $git = new Git;
        $diff = $git->getDiff("HEAD^");

        $this->assertTrue(is_array($diff), "Diff should be returned as an array");
    }

    public function testGetDiffFile()
    {
        $git = new Git;
        $diff = $git->getDiffFile("HEAD^", __FILE__);

        $this->assertTrue(is_array($diff), "Diff should be returned as an array");
    }
}
 