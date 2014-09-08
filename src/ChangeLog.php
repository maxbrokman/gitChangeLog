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
        $tags = array_slice($tags, $this->perPage * ($page - 1), $this->perPage + 1);

        $changeLog = [];

        $i = 0;
        foreach ($tags as $key => $tag) {

            if($i === count($tags) - 1) {
                // no run for last, so we always have a last tag to run log with
                break;
            }

            //tags come back in reverse order remember!
            $lastTag = $tags[$key+1];

            $changeLog[] =
                new ChangeLogEntry([
                    'tag'                   => $tag,
                    'date'                  => (int) $this->git->getDate($tag),
                    'changesSinceLastTag'   => $this->git->getLog($lastTag, $tag) ?: []
                ]);

            $i++;
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