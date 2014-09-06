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
        $tags = array_slice($tags, $this->perPage * ($page - 1), $this->perPage);

        $changeLog = [];

        foreach ($tags as $key => $tag) {

            //tags come back in reverse order remember!
            $lastTag = isset($tags[$key+1]) ? $tags[$key+1] : $this->git->getFirstCommit();

            $changeLog[] =
                new ChangeLogEntry([
                    'tag'                   => $tag,
                    'date'                  => (int) $this->git->getDate($tag),
                    'changesSinceLastTag'   => $this->git->getLog($lastTag, $tag) ?: []
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