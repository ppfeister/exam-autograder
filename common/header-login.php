<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/srv_utils/dbconfig.php");

if(isset($_POST['submit'])) {
    $form_user = $_POST['txt_uname'];
    $form_pass = $_POST['txt_pwd'];
    if ($form_user != "" && $form_pass != "") {
        $query = mysqli_query($con, "SELECT `GUID`, `Username`, `Admin Role`, `First name`, `Last name` FROM `bitlab`.`users` WHERE `Username`=\"$form_user\" and `Password`=\"$form_pass\"");
        $login_query_result = mysqli_fetch_assoc($query);
        if ($login_query_result != false) {
            $_SESSION['username'] = $login_query_result['Username'];
            $_SESSION['guid'] = $login_query_result['GUID'];
            $_SESSION['first_name'] = $login_query_result['First name'];
            $_SESSION['last_name'] = $login_query_result['Last name'];
            $_SESSION['access_level'] = $login_query_result['Admin Role'];
            $_SESSION['logged_in'] = true;
            header("location:/home");
            die;
        } else {
        }
    }
}
?>

<header>
    <div><h1><a href="">&lt;bitlab/&gt;</a></h1></div>
    <div id="login-toolbar">
        <form method="post">
            <input type="text" id="txt_uname" name="txt_uname" placeholder="Username">
            <input type="password" id="txt_uname" name="txt_pwd" placeholder="Password">
            <button type="submit" name="submit"><span class="material-icons-sharp">login</span></button>
        </form>
    </div>
</header>
<div class="page-wrapper"> <!-- closed in footer -->