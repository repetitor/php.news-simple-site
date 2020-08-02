<?php

function template($__view, $__data)
{
    extract($__data);

    ob_start();

    require $__view;

    $output = ob_get_clean();

    return $output;
}

echo render('views/profile.php', ['username' => 'John']);