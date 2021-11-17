<?php include '../srv_utils/dbconfig.php';
session_start();
$con = mysqli_connect($host, $username, $password, $dbname);

$form_user = $_POST['txt_uname'];
$form_pass = $_POST['txt_pwd'];

if ($form_user != "" && $form_pass != "") {

    $login_query_result = mysqli_query($con,"SELECT `GUID` FROM `bitlab`.`users` WHERE `Username`=\"$form_user\" and `Password`=\"$form_pass\"");
    

    if (mysqli_num_rows($login_query_result) == 1) {
        $_SESSION["guid"] = $login_query_result;
        $_SESSION["loggedin"] = true;
        
    }else {

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