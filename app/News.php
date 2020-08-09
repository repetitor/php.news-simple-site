<?php

require_once 'Env.php';


class News
{
    public function test()
    {
        return Env::NEWS_LIMIT_PER_PAGE;
    }

    public static function getCategories()
    {
        return [
            ['id' => '2222', 'name' => 'jjj'],
            ['id' => '222111', 'name' => '111111'],
        ];
    }
}