<?php

namespace Base\Helpers;

class Filter {

    public static function generateSlug($string, $charset = 'utf-8'){
        $string = htmlentities($string, ENT_NOQUOTES, $charset, false);
        $string = preg_replace('~&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);~', '\1', $string);
        $string = preg_replace('~&([A-za-z]{2})(?:lig);~', '\1', $string);
        $string = preg_replace('~&[^;]+;~', '', $string);
        $string = preg_replace('~[\s!*\'();:@&=+$,/?%#[\]]+~', '-', $string);

        return strtolower($string);
    }

    public static function ip() {
        if(getenv('HTTP_CLIENT_IP')) { 
            $ip = getenv('HTTP_CLIENT_IP');
        } else if(getenv('HTTP_X_FORWARDED_FOR')) { 
            $ip = getenv('HTTP_X_FORWARDED_FOR');
        } else if(getenv('HTTP_X_FORWARDED')) { 
            $ip = getenv('HTTP_X_FORWARDED');
        } else if(getenv('HTTP_FORWARDED_FOR')) {
            $ip = getenv('HTTP_FORWARDED_FOR');
        } else if(getenv('HTTP_FORWARDED')) {
            $ip = getenv('HTTP_FORWARDED');
        } else { 
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        return $ip;
    }

}
