<?php
$dbhost = getenv("MYSQL_PROD_URI");
$dbuser = getenv("MYSQL_PROD_USER");
$dbpass = getenv("MYSQL_PROD_TOK");
$con = mysqli_connect($dbhost, $dbuser, $dbpass);
?>