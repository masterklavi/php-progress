
# PHP Progress

Using it you can give nice progress view in command-line interface (CLI)

## Example

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


## Installation

### Using Composer

Get the package:
```
$ composer require masterklavi/phpprogress
```

### Manual Installation

Clone git repository:
```
$ git clone https://github.com/masterklavi/phpprogress.git
```
or download the package at https://github.com/masterklavi/phpprogress/archive/master.zip


## Small Documentation

- `Progress::__construct($max)` where `$max` - max value (count of tasks)
- `Progress::show($offset_or_value = 1, $progress_type = Progress::TYPE_OFFSET, $status = Progress::STATUS_OK)` 
    where 
    - `$offset_or_value` - offset (when type=OFFSET) or value (when type=VALUE)
    - `$progress_type` can be `Progress::TYPE_OFFSET` or `Progress::TYPE_VALUE`
    - `$status` can be `Progress::STATUS_OK`, `Progress::STATUS_SKIP` or `Progress::STATUS_FAIL`

```PHP
$progress = new Progress(10);
$progress->show(); // offset = 1, so value = 1
$progress->show(2); // offset = 2, so value = 3
$progress->show(6, Progress::TYPE_VALUE); // value = 6
$progress->show(4); // offset = 2, so value = 10
```
