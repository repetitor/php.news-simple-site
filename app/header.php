<?php include_once 'helper-old.php'; ?>

<p align="center">HEADER</p>

<hr />

<div>
    <?php
    if(isAuthenicated()){
        include 'logout-form.php';
    } else {
        include 'login-form.php';
    }
    ?>
</div>

<div> <?php include 'menu.php'; ?> </div>
