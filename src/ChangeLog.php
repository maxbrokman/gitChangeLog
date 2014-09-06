<?php


namespace MaxBrokman\GitChangeLog;

class ChangeLog {

    /** @var Git */
    private $git;

    /** @var int */
    public $perPage = 10;

    public function __construct(Git $git)
    {
        $this->git = $git;
    }

    public function getChangeLog($page = 1)
    {
        $tags = $this->git->getTags();
        $tags = array_slice($tags, $page * ($this->perPage - 1), $this->perPage);

        $changeLog = [];

        foreach ($tags as $tag) {
            $changeLog[] =
                new ChangeLogEntry([
                    'tag'                   => $tag,
                    'date'                  => (int) $this->git->getDate($tag),
                    'changesSinceLastTag'   => $this->git->getLog($tag) ?: []
                ]);
        }

        return $changeLog;
    }

    /**
     * @param int $perPage
     */
    public function setPerPage($perPage)
    {
        $this->perPage = $perPage;
    }

} 