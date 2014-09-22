<?php


namespace MaxBrokman\GitChangeLog;

class Git
{
    private $publicMarker = "@public\\|!public";
    private $excludeMarker = "!private";

    public function getTags()
    {
        $command = "git tag -l";
        exec($command, $tags);
        arsort($tags, SORT_NATURAL);

        return array_values($tags);
    }

    public function getLog($from, $to)
    {
        $command = "
                git log \\
                    --grep='$this->publicMarker' \\
                    --relative-date \\
                    --no-merges \\
                    --pretty=format:'{ \"commit\": \"%h\",  \"author\": \"%an <%ae>\",  \"date\": \"%ad\",  \"message\": \"%s\"}' \\
                    $from..$to \\
                | grep -v $this->excludeMarker
        ";

        exec($command, $json);

        $commits = [];

        foreach ($json as $line) {
            $commit = json_decode($line);
            if (json_last_error() === JSON_ERROR_NONE) {
                $commits[] = $commit;
            }
        }

        return $commits;
    }

    public function getDate($tag)
    {
        $command = "git show --format=%at --quiet $tag";

        return exec($command);
    }

    public function getFirstCommit()
    {
        $command = "git log --pretty=format:%H | tail -1";

        return exec($command);
    }

    /**
     * Gets the previous commit hash
     * @param  string $commit
     * @return string $commit - the abbrieviated commit hash of the previous commit
     */
    public function getPreviousCommit($commit)
    {
        $date = $this->getDate($commit);
        $command = "git log --before=$date --max-count=2 --format=%h";
        exec($command, $commits);

        return $commits[1];
    }

    /**
     * Gets diff summary since previous commit
     * @param  string $commit
     * @return array  $diff
     */
    public function getDiff($commit)
    {
        $previousCommit = $this->getPreviousCommit($commit);
        $command = "git diff --stat $previousCommit $commit";
        exec($command, $diff);

        return $diff;
    }

    /**
     * @param string $commit
     * @param string $file
     */
    public function getDiffFile($commit, $file)
    {
        $file = str_replace('-', '/', $file);
        $command = "git diff $commit -- $file";
        exec($command, $diff);

        return $diff;
    }

    /**
     * @param string $publicMarker
     * @codeCoverageIgnore
     */
    public function setPublicMarker($publicMarker)
    {
        $this->publicMarker = $publicMarker;
    }

    /**
     * @param string $excludeMarker
     */
    public function setExcludeMarker($excludeMarker)
    {
        $this->excludeMarker = $excludeMarker;
    }
}
