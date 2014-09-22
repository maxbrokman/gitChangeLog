<?php
/**
 * Created by PhpStorm.
 * User: max.brokman
 * Date: 22/09/2014
 * Time: 13:10
 */

namespace MaxBrokman\GitChangeLog\Tests;

use MaxBrokman\GitChangeLog\DiffList;
use Mockery as m;

class DiffListTest extends \PHPUnit_Framework_TestCase {

    protected function tearDown()
    {
        m::close();
    }

    /**
     * @covers MaxBrokman\GitChangeLog\DiffList::__construct
     * @covers MaxBrokman\GitChangeLog\DiffList::getDiffList
     */
    public function testGetDiffList()
    {
        /** @noinspection PhpParamsInspection */
        $diffList = new DiffList(
            m::mock('MaxBrokman\GitChangeLog\Git')
                ->shouldReceive('getDiff')
                ->once()
                ->andReturn([
                    'file1',
                    'file2',
                    'summary'
                ])
                ->getMock()
        );
        $list = $diffList->getDiffList("HEAD");

        $this->assertArrayHasKey('summary', $list, "List should have summary set");
        $this->assertSame($list['summary'], 'summary', "Summary should be 'summary' with mocked data");

        $this->assertArrayHasKey('fileList', $list, "List should have a list of files (fileList)");
        $this->assertTrue(count($list['fileList']) === 2, "File list should be 2 items long with mocked data");
    }

    /**
     * @covers MaxBrokman\GitChangeLog\DiffList::__construct
     * @covers MaxBrokman\GitChangeLog\DiffList::fileEntries
     */
    public function testFileEntries()
    {
        /** @noinspection PhpParamsInspection */
        $diffList = new DiffList(
            m::mock('MaxBrokman\GitChangeLog\Git')
        );
        $files = $diffList->fileEntries([
            'src/DiffList.php | 45 +++++++++++++++++++++++++++++++++++++++++++++',
            'src/Git.php      | 54 ++++++++++++++++++++++++++++++++++++++++++++++--------'
        ]);

        $this->assertTrue(count($files) === 2, "File list should be 2 items long");
        $this->assertArrayHasKey('file', $files[0], "Each element of file list should have a file");
        $this->assertArrayHasKey('changes', $files[0], "Each element of file list should have a change summary");
        $this->assertSame('src/DiffList.php', $files[0]['file'], "File list file key should be equal to filename");
        $this->assertSame('45 +++++++++++++++++++++++++++++++++++++++++++++',
            $files[0]['changes'],
            "File list changes key should be equal to changes");

    }

}
 