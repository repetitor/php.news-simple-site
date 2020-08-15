<?php


class Env
{
    const URI = 'http://localhost:8000/';

    const DB_SERVERNAME = 'localhost';
//    const DB_SERVERNAME = '172.19.0.2';
//    const DB_SERVERNAME = 'db_service_1';
    const DB_USERNAME = 'root';
    const DB_PASSWORD = '12345678';
    const DB_NAME = 'db';

    const MAIN_TEMPLATE_PATH = 'views/templates/main/template.php';
    const LINK_MAIN_TEMPLATE_CSS = self::URI . 'views/templates/main/style.css';

    const DEFAULT_TITLE_TAB = 'Новости';
    const NEWS_LIMIT_PER_PAGE = 10;
}