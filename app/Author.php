<?php

require_once 'Database.php';


class Author
{
    public static function getAll()
    {
        return Database::getAllFromTable('authors');
    }
}