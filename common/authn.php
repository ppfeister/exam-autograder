<!-- Hypothetical Table Code
    CREATE TABLE users (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
--> 

<?php



if(isset($_POST['but_submit'])) {
    $con = mysqli_connect('localhost',$user, $username, 'table');
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
}

?>