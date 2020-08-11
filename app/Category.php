<?php

require_once 'Database.php';


class Category
{
    public static function getAll()
    {
        return Database::getAllFromTable('categories');
    }
}