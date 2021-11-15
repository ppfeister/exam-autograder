<?php include '../srv_utils/dbconfig.php';



if(isset($_POST['but_submit'])) {
    $con = mysqli_connect($host, $username, $password, $dbname);
    //$uname = mysqli_real_escape_string($con,$_POST['txt_uname']);
    //$password = mysqli_real_escape_string($con,$POST['txt_pwd']);

    $html_uname = $_POST['txt_uname'];
    $html_pword = $_POST['txt_pwd'];

    if ($html_uname != "" && $html_pword != "") {

        $sql_username = mysqli_query($con,"SELECT Username FROM `bitlab`.`users`");
        $sql_password = mysqli_query($con,"SELECT Password FROM `bitlab`.`users`");

        //$result = mysqli_query($con,$sql_query);
        //$row = mysqli_query($con,$sql_query);
        //$count = $row['cntUser'];

        if (strcmp($html_uname, $sql_username) && strcmp($html_pword, $sql_password)) {
            //set page to courses page
        }else {
            echo "wrong password";
        }
    }
}

?>