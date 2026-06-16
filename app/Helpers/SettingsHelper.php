<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

if (!function_exists('get_setting')) {
    function get_setting($key, $default = null)
    {
        // Cache the settings to avoid multiple DB queries
        $settings = Cache::rememberForever('global_settings', function () {
            return Setting::pluck('value', 'key')->toArray();
        });

        return $settings[$key] ?? $default;
    }
}

if (!function_exists('set_setting')) {
    function set_setting($key, $value)
    {
        Setting::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
        
        // Clear the cache when a setting is updated
        Cache::forget('global_settings');
    }
}

if (!function_exists('numberToWord')) {
    function numberToWord($number)
    {
        $no = round($number);
        $decimal = round($number - ($no = floor($number)), 2) * 100;    
        $digits_length = strlen($no);    
        $i = 0;
        $str = array();
        $words = array(
            0 => '',
            1 => 'One',
            2 => 'Two',
            3 => 'Three',
            4 => 'Four',
            5 => 'Five',
            6 => 'Six',
            7 => 'Seven',
            8 => 'Eight',
            9 => 'Nine',
            10 => 'Ten',
            11 => 'Eleven',
            12 => 'Twelve',
            13 => 'Thirteen',
            14 => 'Fourteen',
            15 => 'Fifteen',
            16 => 'Sixteen',
            17 => 'Seventeen',
            18 => 'Eighteen',
            19 => 'Nineteen',
            20 => 'Twenty',
            30 => 'Thirty',
            40 => 'Forty',
            50 => 'Fifty',
            60 => 'Sixty',
            70 => 'Seventy',
            80 => 'Eighty',
            90 => 'Ninety');
        $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
        while ($i < $digits_length) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += $divider == 10 ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;            
                $str [] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural;
            } else {
                $str [] = null;
            }  
        }
        $Rupees = implode(' ', array_reverse($str));
        return ($Rupees ? 'Rupees ' . $Rupees : '') . 'Only';
    }
}
