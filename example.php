<?php

use masterklavi\phpprogress\Progress;

require 'lib/Progress.php';

// init progress of 500 tasks
$progress = new Progress(500);

for ($i = 0; $i < 500; $i++)
{
    // some task
    usleep(rand(0, 50000));

    // mark that a task was completed
    $progress->show();
}
