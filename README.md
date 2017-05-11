
# PHP Progress

Using it you can give nice progress view in command-line interface (CLI)

## Examples

```PHP
use masterklavi\phpprogress\Progress;

// init progress of 500 tasks
$progress = new Progress(500);

for ($i = 0; $i < 500; $i++)
{
    // some task
    usleep(rand(0, 50000));

    // mark that a task was completed
    $progress->show();
}
```


## Requirements

- PHP version 5.4.0 or higher
