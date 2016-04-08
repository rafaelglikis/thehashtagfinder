<?php
class TextHelper
{
    # Returns the string value from data between start - end
    static function strCut($str, $start='', $end='')
    {
        if ($start == '')
        {
            $intStart = 0;
        }
        else
        {
            $intStart = strpos($str,$start) + strlen($start);
        }

        if ($end == '')
        {
            $intEnd = strlen($str);
        }
        else
        {
            $intEnd = strpos($str,$end);
        }


        $cut = substr($str,$intStart,$intEnd);

        return $cut;
    }
}