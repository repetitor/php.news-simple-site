<?php

function template($__view, $__data)
{
    extract($__data);

    ob_start();

    require $__view;

    $output = ob_get_clean();

    return $output;
}

function body($viewBody, $paramsArray){

//    echo template('views/template.php', ['username' => 'John']);
    echo render('views/template.php', ['viewBody' => $viewBody, 'params' => $paramsArray]);

}

function renderBody(){
    $params = [
        'p1' => 'v1',
        'p2' => 'v2',
    ];
    $renderBody = render('views/body.php', $params);

    return $renderBody;
}

$bodyParams = [
    'title' => 'body title',
    'p1' => 'v1',
    'p2' => 'v2',
    'content' => renderBody(),
];
body('views/body.php', $bodyParams);