<?php

namespace masterklavi\phpprogress;

class Progress
{
    /**
     * Maximum value
     * @var integer
     */
    protected $max = null;

    /**
     * Current value
     * @var integer
     */
    protected $value = 0;

    /**
     * Width of the progress line
     * @var integer
     */
    protected $line_width = null;

    /**
     * Indicator for range control
     * @var boolean
     */
    protected $out_of_range = false;

    const TYPE_OFFSET = 1;
    const TYPE_VALUE = 2;

    const STATUS_OK = '.';
    const STATUS_SKIP = '_';
    const STATUS_FAIL = 'F';

    /**
     * Initializes a new object
     * @param integer $max
     */
    public function __construct($max)
    {
        // set max
        
        if (ctype_digit((string)$max) == false)
        {
            throw new \Exception('Max value must contain digits only (integer, positive)');
        }

        if ($max == 0)
        {
            throw new \Exception('Max value must be greater than zero');
        }

        $this->max = (int)$max;

        // set line_width

        $cols = (int)shell_exec('tput cols');

        if ($cols === 0)
        {
            $cols = 100;
        }
        
        if ($this->max < $cols*5)
        {
            $cols = (int)($cols/2);
        }
        
        $this->line_width = $cols - 30;
    }

    /**
     * Shows progress
     * @param integer $offset_or_value
     * @param integer $progress_type
     */
    public function show($offset_or_value = 1, $progress_type = self::TYPE_OFFSET, $status = self::STATUS_OK)
    {
        if ($progress_type === self::TYPE_OFFSET)
        {
            $offset = (int)$offset_or_value;
        }
        elseif ($progress_type === self::TYPE_VALUE)
        {
            $offset = $offset_or_value - $this->value;
        }
        else
        {
            throw new Exception('Unknown type');
        }

        if ($this->out_of_range)
        {
            print str_repeat($status, $offset);
            return;
        }

        if ($offset <= 0 || !is_int($offset))
        {
            return;
        }

        $this->value += $offset;

        if ($this->value > $this->max)
        {
            $this->out_of_range = true;
            print PHP_EOL;
            print 'OUT OF RANGE: ';
            print str_repeat($status, $offset);
            return;
        }

        static $start_time = null;
        static $start_value = null;

        if ($start_time === null)
        {
            $start_time = microtime(true);
            $start_value = $this->value;
        }

        print str_repeat($status, $offset);

        if ($this->value % $this->line_width === 0 && $this->value > 0)
        {
            $p = round($this->value/$this->max*100);

            $seconds = ($this->max - $this->value)/($this->value - $start_value)*(microtime(true) - $start_time);
            if ($seconds < 100)
            {
                $remained = floor($seconds).'s';
            }
            elseif ($seconds < 6000)
            {
                $remained = floor($seconds/60).'m';
            }
            elseif ($seconds < 360000)
            {
                $remained = floor($seconds/3600).'h';
            }
            else
            {
                $remained = floor($seconds/3600/24).'d';
            }

            printf(' %8d of %-8d %2d%% %3s', $this->value, $this->max, $p, $remained);
            print PHP_EOL;
        }
        elseif ($this->value == $this->max)
        {
            print str_repeat(' ', $this->line_width - ($this->value % $this->line_width));
            printf(' %8d of %-8d 100%%   ', $this->value, $this->max);
            print PHP_EOL;
        }
    }
}
