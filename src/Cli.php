<?php

namespace Gevman\Cli;

/**
 * Class Cli
 * @package Gevman\Cli
 */
class Cli
{
    /**
     * Interactive confirm
     *
     * @param string $prompt - prompt message
     * @param bool $default - default value
     * @return bool - user selected value (Y=true, N=false)
     */
    public static function confirm($prompt = '', $default = true)
    {
        if (is_null($default)) {
            $default = false;
        }
        if (strlen($prompt) > 0) {
            $prompt .= ' ';
        };
        $prompt .= ($default ? '[Y/n] ' : '[y/N] ');
        while (true) {
            print $prompt;
            $in = chop(fgets(STDIN));
            if ($in == '') return $default;
            if ($in == 'Y' || $in == 'y') {
                return true;
            } elseif ($in == 'N' || $in == 'n') {
                return false;
            }
            return $default;
        }
        return $default;
    }

    /**
     * Interactive user input
     *
     * @param $input - variable reference
     * @param string $message - message
     * @param bool $required - input required
     */
    public static function input(&$input, $message = '', $required = false)
    {
        $in = '';
        while (true) {
            echo $message;
            $in = chop(fgets(STDIN));
            if (empty($in) && $required) {
                continue;
            }
            break;
        }
        $input = $in;
    }

    /**
     * Outputs message
     *
     * @param string $str - message or pattern
     * @param mixed $_ [optional] - pattern parts
     * @return CliOutput
     */
    public static function output($str = null, $_ = null)
    {
        $args = func_get_args();
        if (empty($args)) {
            $args[0] = '';
        }
        return new CliOutput(call_user_func_array('sprintf', $args));
    }
}