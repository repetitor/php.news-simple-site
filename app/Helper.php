<?php

require_once 'Env.php';

class Helper
{
    /**
     * connect to database || fail
     *
     * @return PDO|string
     */
    public static function connectDatabase()
    {
        $servername = Env::DB_SERVERNAME;
        $username = Env::DB_USERNAME;
        $password = Env::DB_PASSWORD;
        $dbname = Env::DB_NAME;

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $conn;
        } catch(PDOException $e) {
            return "Connection failed: " . $e->getMessage();
        }
    }

    public function queryDatabase($statement)
    {
        return self::connectDatabase()->query($statement);
    }

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

        return substr($textWithoutSigns, 0, strrpos($textWithoutSigns, ' ')) . '...';
    }
}