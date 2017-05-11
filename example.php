<?php

use masterklavi\phpprogress\Progress;

require 'lib/Progress.php';

// init progress of 500 tasks
$progress = new Progress(500);

for ($i = 0; $i < 500; $i++)
{
    // some task
    usleep(rand(0, 50000));

    if ($i % 100 === 0)
    {
        // mark that a task was failed
        $progress->show(1, Progress::TYPE_OFFSET, Progress::STATUS_FAIL);
    }
    elseif ($i > 150 && $i < 160)
    {
        // mark that a task was skipped
        $progress->show(1, Progress::TYPE_OFFSET, Progress::STATUS_SKIP);
    }
    else
    {
        // mark that a task was completed
        $progress->show();
    }
}
