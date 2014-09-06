<?php


namespace MaxBrokman\GitChangeLog;

class Git {

    private $publicMarker = "@public";

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
                    --grep=$this->publicMarker \\
                    --relative-date \\
                    --pretty=format:'{ \"commit\": \"%h\",  \"author\": \"%an <%ae>\",  \"date\": \"%ad\",  \"message\": \"%s\"}' \\
                    $from..$to
        ";

        exec($command, $json);

        $commits = [];

        foreach($json as $line) {
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
     * @param string $publicMarker
     * @codeCoverageIgnore
     */
    public function setPublicMarker($publicMarker)
    {
        $this->publicMarker = $publicMarker;
    }


} 