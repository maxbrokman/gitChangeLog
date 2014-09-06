<?php

use MaxBrokman\GitChangeLog\ChangeLog;
use MaxBrokman\GitChangeLog\Git;

require __DIR__ . "./../vendor/autoload.php";
date_default_timezone_set('UTC');

$git = new Git();
$changeLog = new ChangeLog( $git );
$log = $changeLog->getChangeLog(1);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>GitChangeLog Example</title>
</head>
<body>
    <ul>
        <?php foreach ($log as $tag) {

            ?>
            <li>
                <h3>
                    <?php echo $tag->tag; ?>: <?php echo date("Y m d", $tag->date); ?>
                </h3>

                <?php foreach($tag->changesSinceLastTag as $change) {
                    ?>

                        <p>
                            <?php echo $change->message; ?>
                        </p>

                        <p>
                            <?php echo $change->author; ?> authored commit <?php echo $change->commit; ?> <?php echo $change->date; ?>
                        </p>

                    <?php
                } ?>

            </li>

        <?php
        }
        ?>

    </ul>
</body>
</html>

