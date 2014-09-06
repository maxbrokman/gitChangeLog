<?php


namespace MaxBrokman\GitChangeLog;

class Git {

    private $publicMarker = "@public";

    public function getTags()
    {
        $command = "git tag -l";
        exec($command, $tags);
        arsort($tags);
        return $tags;
    }

    public function getLog($tag)
    {
        $command = "
                git log \\
                    --grep=$this->publicMarker \\
                    --relative-date \\
                    --pretty=format:'{ \"commit\": \"%h\",  \"author\": \"%an <%ae>\",  \"date\": \"%ad\",  \"message\": \"%s\"}' \\
                    $tag
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
        $command = "git show --format=%ar --quiet $tag";

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