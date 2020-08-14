<?php

require_once 'Env.php';
require_once 'Helper.php';
require_once 'RequestResponse.php';
require_once 'View.php';

session_start();
$isAdmin = Helper::isAdmin();
$response = (new RequestResponse())->getResponse();

$view = new View();

$content = $view->render(
    $response['view-file-path'],
    array_merge(
        $response['data'],
        ['is_admin' => $isAdmin]
    )
);

$page = $view->injectInTemplate($content, [
    'can-auth' => true,
    'is-admin' => $isAdmin,

    'title-tab' => $response['title-tab'] ?? Env::DEFAULT_TITLE_TAB,
    'categories' => $response['categories'] ?? null,
]);

echo $page;