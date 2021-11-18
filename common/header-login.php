<?php
// DB Info Begin
session_start();
$host = getenv("MYSQL_PROD_URI");
$dbname = "bitlab";
$username = getenv("MYSQL_PROD_USER");
$password = getenv("MYSQL_PROD_TOK");

$con = mysqli_connect($host, $username, $password, $dbname);
// DB Info End

if(isset($_POST['submit'])) {
    $form_user = $_POST['txt_uname'];
    $form_pass = $_POST['txt_pwd'];
    if ($form_user != "" && $form_pass != "") {
        $login_query_result = mysqli_query($con, "SELECT `GUID` FROM `bitlab`.`users` WHERE `Username`=\"$form_user\" and `Password`=\"$form_pass\"");
        if ($login_query_result->num_rows > 0) {
            $_SESSION['username'] = $form_user;
            header("location:courses/index.php");
            die;
        } else {
            alert("failed");
        }
    }
}
?>

<header>
    <div><h1><a href="">bitlab</a></h1></div>
    <div id="login-toolbar">
        <form method="post">
            <input type="text" id="txt_uname" name="txt_uname" placeholder="Username">
            <input type="password" id="txt_uname" name="txt_pwd" placeholder="Password">
            <button type="submit" name="submit"><span class="material-icons-sharp">login</span></button>
        </form>
    </div>
</header>
<div class="page-wrapper"> <!-- closed in footer -->