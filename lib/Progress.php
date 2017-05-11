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

    /**
     * Initializes a new object
     * @param integer $max
     */
    public function __construct($max)
    {
        $this->setMax($max);

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
     * Sets maximum value
     * @param integer $max
     */
    public function setMax($max)
    {
        if (ctype_digit((string)$max) == false)
        {
            throw new \Exception('Max value must contain digits only (integer, positive)');
        }

        if ($max == 0)
        {
            throw new \Exception('Max value must be greater than zero');
        }
        
        $this->max = (int)$max;
    }

    /**
     * Shows progress by offset
     * @param integer $offset
     */
    public function show($offset = 1)
    {
        $this->value += $offset;

        if ($this->value > $this->max)
        {
            if ($this->out_of_range === false)
            {
                $this->out_of_range = true;
                print PHP_EOL;
                print 'OUT OF RANGE: ';
            }
            else
            {
                print str_repeat('.', $offset);
                return;
            }
        }

        print str_repeat('.', $offset);

        static $start_time = null;
        static $start_value = null;

        if ($start_time === null)
        {
            $start_time = microtime(true);
            $start_value = $this->value;
        }

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
