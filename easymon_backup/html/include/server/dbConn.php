<?php

    $host = "127.0.0.1";
    $user = "root";
    $password = "Neungsoft1!";
    $dbname = "EASYMON";

    $link = mysqli_connect($host, $user, $password, $dbname);

    if (mysqli_connect_errno()) {
        die('Connect Error: '.mysqli_connect_error());
    }


?>