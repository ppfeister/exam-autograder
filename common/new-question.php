<?php include '../srv_utils/dbconfig.php';

    $db_c = 'correct_answer'; $db = 'input_answer';
    $con = mysqli_connect('localhost',$user, $username, $db_c);
    $con_input = $_POST['input'];

?>