<?php

require_once 'Env.php';
require_once 'Helper.php';
require_once 'RequestResponse.php';

session_start();

$helper = new Helper();

$isAdmin = $helper->isAdmin();

$response = (new RequestResponse())->getResponse();
$response['content']['data']['is_admin'] = $isAdmin;

$contentRendered = $helper->render($response['content']);

$response['template']['data']['is_admin'] = $isAdmin;
$response['template']['data']['content_rendered'] = $contentRendered;

$page = $helper->render($response['template']);

echo $page;