<?php

require_once 'Env.php';

class Helper
{
    public static function isAdmin(){
        $login = 'admin';
        $password = 'password';

        // check login-form
        if(isset($_POST['login']) && $_POST['login'] == $login){
            $loginAuth = true;
        } else {
            $loginAuth = false;
        }

        if(isset($_POST['password']) && $_POST['password'] == $password){
            $passwordAuth = true;
        } else {
            $passwordAuth = false;
        }

        if($loginAuth && $passwordAuth){
            $_SESSION['auth'] = true;
        }

        // check logout-form
        if(isset($_POST['exit'])){
            $_SESSION['auth'] = false;
        }

        // result
        if(isset($_SESSION['auth']) && $_SESSION['auth'] == true){
            return true;
        } else {
            return false;
        }
    }

    /**
     * get text like "Hello, my..."
     *
     * @param $text
     * @param $maxLength
     * @return false|string
     */
    public static function trimText($text, $maxLength){
        $textMaxLength = substr($text, 0, $maxLength);
        $textWithoutSigns = rtrim($textMaxLength, "!,.-");
//        $textTrimLastSpace = substr($textWithoutSigns, 0, strrpos($textWithoutSigns, ' '));

        return $textWithoutSigns . '...';
//        return $textTrimLastSpace . '...';
    }

    public static function fromUtcToLocalTime($utcTime, $format='Y-m-d H:i:s')
    {
        $datetime = date_create($utcTime, timezone_open('UTC'));
//        $tz = date_timezone_get($datetime);
//        echo timezone_name_get($tz);
//        echo $datetime->format('H:i');

        date_timezone_set($datetime, timezone_open('Europe/Minsk'));

        return $datetime->format($format);
    }
}