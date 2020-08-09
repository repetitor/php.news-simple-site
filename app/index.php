<?php
//header("Access-Control-Allow-Origin: *");

require_once 'Env.php';
require_once 'RequestResponse.php';
require_once 'View.php';

$response = (new RequestResponse())->getResponse();

$view = new View();
$div = $view->render($response['view-file-path'], $response['data']);
$page = $view->injectInTemplate($div, Env::DEFAULT_TITLE_TAB);

echo $page;