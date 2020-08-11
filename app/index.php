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
        ['has_permission_change' => $isAdmin]
    )
);

$form = $isAdmin ? 'logout-form.php' : 'login-form.php';
$renderLoginLogoutForm = $view->render('views/auth/' . $form);

$page = $view->injectInTemplate($content, [
    'title-tab' => $response['title-tab'] ?? Env::DEFAULT_TITLE_TAB,
    'login-logout-form' => $renderLoginLogoutForm,
    'categories' => $response['categories'] ?? null,
    'authenticated' => $isAdmin,
]);

echo $page;