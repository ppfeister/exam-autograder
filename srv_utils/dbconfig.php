<?php
/*$host = getenv("MYSQL_PROD_URI");
$dbname = "bitlab";
$username = getenv("MYSQL_PROD_USER");
$password = getenv("MYSQL_PROD_TOK");*/


$host = "prod.mysql.bitlab.pfei.cc";
$dbname = "bitlab";
$username = "bitlab-srv";
$password = "rHG0YySFgTv3KBt5";

$con = mysqli_connect($host, $username, $password, $dbname);
?>