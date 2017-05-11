<?php

use masterklavi\phpprogress\Progress;

require 'lib/Progress.php';

$progress = new Progress(500);

for ($i = 0; $i < 500; $i++)
{
    $progress->show();
    usleep(rand(0, 50000));
}
