<?php include '../srv_utils/dbconfig.php';
    // This file manages the storing of qbanks and the comparing 
    //of different answers. We utilize 2 different databases



    $con = mysqli_connect('localhost',$user, $username, $db_c);
    $con_input = mysqli_connect('localhost',$user, $username, $db);

    $answer_correct = array();
    $answer = array();

    while ($row = mysqli_fetch_array($con)) {
        $answer_correct[] = $row['column-x'];
    }

    while ($row = mysqli_fetch_array($con_input)) {
        $answer[] = $row['column-x'];
    }



    //Have some 2d array thing which parses question banks and then
    //applys it to $insert_answer
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['submit'])) {
            $insert_answer = "INSERT INTO input_answer (qkey, question) 
            VALUES ($qkey, $question)";
            $con_input->query($insert_answer, $con_input);
        }
    }

?>