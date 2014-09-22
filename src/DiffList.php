<?php


namespace MaxBrokman\GitChangeLog;

class DiffList
{
    /** @var Git */
    private $git;

    public function __construct(Git $git)
    {
        $this->git = $git;
    }

    /**
     * @param string $commit
     */
    public function getDiffList($commit)
    {
        $diff = $this->git->getDiff($commit);

        return [
            'summary' => trim(array_pop($diff)),
            'fileList' => $diff
        ];
    }

    /**
     * @param array $files
     */
    public function fileEntries($files)
    {
        $list = [];
        foreach ($files as $file) {
            list($file, $changes) = explode(' | ', $file);
            $list[] = [
                'file' => trim($file),
                'changes' => trim($changes)
            ];
        }

        return $list;
    }
}
