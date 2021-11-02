<!-- Hypothetical Table Code
    CREATE TABLE users (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
--> 

<?php

require_once 'dbconfig.php';

if(isset($_POST['but_submit']) {
    $uname = mysqli_real_escape_string($con,$_POST['txt_uname']);
    $password = mysqli_real_escape_string($con,$POST['txt_pwd']);

    if ($uname != "" && $password != "") {
        //check for passwords within system

        $sql_query = "select count(*) as cntUser 
            from user 
            where username='".$uname."' and password='".$password."'";
        $resuilt = mysqli_query($con,$sql_query);
        $row = mysqli_query($con,$sql_query);
        $count = $row['cntUser'];

        if ($count > 0) {
            //set page to courses page
        }else {
            echo "wrong password lmao";
        }
    }
})

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Coding examination website with automatic grading of student-submitted code">
    <title>Coding Exam Software</title>
    <link rel="stylesheet" href="styles/master.css" type="text/css">
</head>
<body>
    <header>
        <div><h1><a href="">Bitlab</a></h1></div>
        <div id="login-toolbar">
            <form>
                <input type="text" id="txt_uname" name="txt_uname" placeholder="Username">
                <input type="password" id="txt_uname" name="txt_pwd" placeholder="Password">
            </form>
        </div>
    </header>
</body>
</html>
