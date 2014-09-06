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
                    --pretty=format:'{%n  \"commit\": \"%h\",%n  \"author\": \"%an <%ae>\",%n  \"date\": \"%ad\",%n  \"message\": \"%f\"%n},' \\
                    $tag
                $@ | \\
                perl -pe 'BEGIN{print \"[\"}; END{print \"]\n\"}' | \\
                perl -pe 's/},]/}]/'
        ";

        $json = exec($command);

        return json_decode($json);
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