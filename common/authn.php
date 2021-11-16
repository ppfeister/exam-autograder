<?php include '../srv_utils/dbconfig.php';



if(isset($_POST['but_submit'])) {
    $con = mysqli_connect($host, $username, $password, $dbname);
    //$uname = mysqli_real_escape_string($con,$_POST['txt_uname']);
    //$password = mysqli_real_escape_string($con,$POST['txt_pwd']);

    $html_uname = $_POST['txt_uname'];
    $html_pword = $_POST['txt_pwd'];

    if ($html_uname != "" && $html_pword != "") {

        $sql_userpw = mysqli_query($con,"SELECT GUID FROM bitlab.users WHERE Username=“$html_uname” and Password=$html_pass");
        //$sql_password = mysqli_query($con,"SELECT $html_pword FROM `bitlab`.`users`");

        //$result = mysqli_query($con,$sql_query);
        //$row = mysqli_query($con,$sql_query);
        //$count = $row['cntUser'];

        if (mysqli_num_rows($sql_userpw) < 1) {
            //error page
        }else {
            //continue to page
        }
    }
}

?>