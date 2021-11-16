<?php

$host = getenv("MYSQL_PROD_URI");
$dbname = "bitlab";
$username = getenv("MYSQL_PROD_USER");
$password = getenv("MYSQL_PROD_TOK");

$con = mysqli_connect($host, $username, $password, $dbname);
//$uname = mysqli_real_escape_string($con,$_POST['txt_uname']);
//$password = mysqli_real_escape_string($con,$POST['txt_pwd']);

$form_user = $_POST['txt_uname'];
$form_pass = $_POST['txt_pwd'];

if ($form_user != "" && $form_pass != "") {

    $login_query_result = mysqli_query($con,"SELECT `GUID` FROM `bitlab`.`users` WHERE `Username`=\"$form_user\" and `Password`=\"$form_pass\"");
    //$sql_password = mysqli_query($con,"SELECT $html_pword FROM `bitlab`.`users`");

    //$result = mysqli_query($con,$sql_query);
    //$row = mysqli_query($con,$sql_query);
    //$count = $row['cntUser'];

    if (mysqli_num_rows($login_query_result) < 1) {
        alert("failed");
    }else {
        alert("match");
    }
}
?>

<header>
    <div><h1><a href="">bitlab</a></h1></div>
    <div id="login-toolbar">
        <form>
            <input type="text" id="txt_uname" name="txt_uname" placeholder="Username">
            <input type="password" id="txt_uname" name="txt_pwd" placeholder="Password">
            <button type="submit"><span class="material-icons-sharp">login</span></button>
        </form>
    </div>
</header>
<div class="page-wrapper"> <!-- closed in footer -->