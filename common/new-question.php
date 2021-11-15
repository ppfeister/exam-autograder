<?php include '../srv_utils/dbconfig.php';
    $con = mysqli_connect($host, $username, $password, $dbname);
    
    $con_input = $_POST['input'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['submit'])) {
            
          } else {
          }
    }

?>