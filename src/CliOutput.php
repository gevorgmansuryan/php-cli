<?php

namespace Gevman\Cli;

/**
 * Class CliOutput
 * @package Gevman\Cli
 */
class CliOutput
{
    private static $colorSupport;
    private static $progressBarPad = 0;
    private $output;



    private $foreground_colors = [
        FgColor::Black,
        FgColor::DarkGray,
        FgColor::LightGray,
        FgColor::Blue,
        FgColor::LightBlue,
        FgColor::Green,
        FgColor::LightGreen,
        FgColor::Cyan,
        FgColor::LightCyan,
        FgColor::Red,
        FgColor::LightRed,
        FgColor::Purple,
        FgColor::LightPurple,
        FgColor::Brown,
        FgColor::Yellow,
        FgColor::White
    ];

    private $background_colors = [
        BgColor::Black,
        BgColor::Red,
        BgColor::Green,
        BgColor::Yellow,
        BgColor::Blue,
        BgColor::Magenta,
        BgColor::Cyan,
        BgColor::LightGray
    ];

    /**
     * CliOutput constructor.
     * @param $output
     */
    public function __construct($output)
    {
        $this->output = $output;
    }

    /**
     * Marks output green
     *
     * @return $this
     */
    public function success()
    {
        $this->colorize(FgColor::Green);
        return $this;
    }

    /**
     * Marks output Yellow
     *
     * @return $this
     */
    public function warning()
    {
        $this->colorize(FgColor::Yellow);
        return $this;
    }

    /**
     * Marks output Red
     *
     * @return $this
     */
    public function error()
    {
        $this->colorize(null, BgColor::Red);
        return $this;
    }

    /**
     * Marks output Blue
     *
     * @return $this
     */
    public function note()
    {
        $this->colorize(FgColor::LightBlue);
        return $this;
    }

    /**
     * Displays interactive progressbar (message should be current key)
     *
     * @param int|float $all - count of all
     * @param string $additionalInfo - displays additional Info for each step
     */
    public function progressBar($all = null, $additionalInfo = '')
    {
        if ($additionalInfo === true) {
            $additionalInfo = sprintf('%s of %s', $this->output, $all);
        }
        if (!is_null($additionalInfo)) {
            self::$progressBarPad = strlen($additionalInfo) > self::$progressBarPad ? strlen($additionalInfo) : self::$progressBarPad;
            $additionalInfo = str_pad("($additionalInfo)", self::$progressBarPad + 2);
        }
        if ($all) {
            $value = intval((floatval($this->output)/$all)*100);
        } else {
            $value = intval(round(intval($this->output)));
        }
        $this->output = '';
        for ($i = 0; $i < 50; $i++) {
            $this->output.= $i < $value/2 ? '=' : ' ';
        }
        $this->output.= sprintf("| %s%% %s", str_pad($value, 3, ' ', STR_PAD_LEFT), $additionalInfo);
        $this->colorize(FgColor::Black, BgColor::LightGray);
        if ($value == 100) {
            $this->endl();
            self::$progressBarPad = 0;
        } else {
            $this->cl();
        }
    }

    /**
     * Colorize the output
     *
     * @param string $foreground_color
     * @param string $background_color
     * @return $this
     */
    public function colorize($foreground_color=null, $background_color=null)
    {
        if ($this->supportsColors()) {
            $colored_string = "";
            if (in_array($foreground_color, $this->foreground_colors)) {
                $colored_string .= "\033[" . $foreground_color . "m";
            }
            if (in_array($background_color, $this->background_colors)) {
                $colored_string .= "\033[" . $background_color . "m";
            }

            $this->output = $colored_string .  $this->output . "\033[0m";
        }
        return $this;
    }

    /**
     * @method output
     * @param string $str
     * @param mixed $_ [optional]
     * @return CliOutput
     */
    public function output($str=null, $_=null)
    {
        $args = func_get_args();
        if (empty($args)) {
            $args[0] = '';
        }
        return new CliOutput(call_user_func_array('sprintf', $args));
    }

    /**
     * Line break
     *
     * @return $this
     */
    public function endl()
    {
        $this->output .= PHP_EOL;
        return $this;
    }

    /**
     * Clear current line
     *
     * @return $this
     */
    public function cl()
    {
        $this->output.="\r";
        return $this;
    }

    /**
     * Check if terminal supports colors
     *
     * @return bool
     */
    private function supportsColors()
    {
        if (!self::$colorSupport) {
            $supportedColors = [];
            self::$colorSupport = boolval(intval(@exec("tput colors 2>&1", $supportedColors))); 
        }
        return self::$colorSupport;
    }


    /**
     * Print final output
     */
    public function __destruct()
    {
        echo $this->output;
        $this->output = null;
        flush();
    }
}