<?php

require_once 'Env.php';


class Database
{
    /**
     * connect to database || fail
     *
     * @return PDO|string
     */
    private static function connect()
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

    public static function query($statement)
    {
        return self::connect()->query($statement);
    }

    public static function insertGetLastId($statement)
    {
        $conn = self::connect();
        $conn->query($statement)->execute();

        return $conn->lastInsertId();
    }

    public static function getAllFromTable($table)
    {
        $PDOStatement = self::query("SELECT * FROM $table ORDER BY id ASC");

        $items = [];

        foreach ($PDOStatement as $item){
            array_push($items, $item);
        }

        return $items;
    }
}