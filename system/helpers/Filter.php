<?php

namespace app\system\helpers;

Class Filter {

    public static function ckey(): string
    {
        return bin2hex(random_bytes(16));
    }

    public static function clean($string): string
    {
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); 
    }

    public static function html($string): string
    {

        $string = nl2br($string);
        $string = htmlspecialchars($string);
        $string = addslashes($string);

        return $string;
    }

    public static function post($string): string
    {
        return strip_tags(addslashes(trim($string)));
    }

    public static function html_decode($string): string
    {
        return stripslashes(htmlspecialchars_decode(htmlspecialchars_decode($string)));
    }

}