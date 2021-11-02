<?php
    session_start();
    $host = 'localhost';
    $dbname = 'logintable';
    $username = 'root';
    $password = '';

    $con = mysqli_connect($host, $user, $username, $dbname);
    if (!$con) {

        die("connection failed" . mysqli_connect_error());
    }