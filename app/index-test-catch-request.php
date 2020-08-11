<?php

require_once 'Env.php';
require_once 'Helper.php';
require_once 'RequestResponse.php';
require_once 'View.php';

header("Access-Control-Allow-Origin: *");

const TYPE_RESPONSE_JSON = 'json';
const TYPE_RESPONSE_PAGE = 'page';
const TYPE_RESPONSE_DIV = 'div';

// default
//$typeResponse = TYPE_RESPONSE_JSON;
//if(isset($_GET['get']) && $_GET['get'] == TYPE_RESPONSE_PAGE){
//    $typeResponse = TYPE_RESPONSE_PAGE;
//}
//if(isset($_GET['get']) && $_GET['get'] == TYPE_RESPONSE_DIV){
//    $typeResponse = TYPE_RESPONSE_DIV;
//}
$typeResponse = $_GET['get'] ?? TYPE_RESPONSE_JSON;

// may be return json - a)
$apiGet = ($typeResponse == TYPE_RESPONSE_JSON);

$inputContents = json_decode(file_get_contents('php://input'), true);
// may be return json - b)
$apiInput = (isset($inputContents['get-from-body-raw']) && $inputContents['get-from-body-raw'] == 'postman wants json');

// may be return json - c)
$apiFormData = (isset($_POST['get-from-body-form-data']) && $_POST['get-from-body-form-data'] == 'json');

if($apiGet || $apiInput || $apiFormData){
    $typeResponse = TYPE_RESPONSE_JSON;
    header('Content-type: application/json');
//    header("Access-Control-Allow-Origin: *");
}

session_start();

$isAdmin = Helper::isAdmin();

$response = (new RequestResponse())->getResponse();

if($typeResponse == TYPE_RESPONSE_JSON){
    echo json_encode($response);
} else {
    $view = new View();

//    $div = $view->render($response['view-file-path'], $response['data']);
    $content = $view->render(
        $response['view-file-path'],
        array_merge(
            $response['data'],
            ['has_permission_change' => $isAdmin]
        )
    );

    if($typeResponse == TYPE_RESPONSE_DIV){
        echo $content;
    }

    if($typeResponse == TYPE_RESPONSE_PAGE){
//        $page = $view->injectInTemplate($div, 'test-catch-request');
//        echo $page;
        $form = $isAdmin ? 'logout-form.php' : 'login-form.php';
        $renderLoginLogoutForm = $view->render('views/auth/' . $form);

        $page = $view->injectInTemplate($content, [
            'title-tab' => $response['title-tab'] ?? Env::DEFAULT_TITLE_TAB,
            'login-logout-form' => $renderLoginLogoutForm,
            'categories' => $response['categories'] ?? null,
            'authenticated' => $isAdmin,
        ]);

        echo $page;
    }
}
