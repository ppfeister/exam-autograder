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

$user = "";
$pword = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
}

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
                <input type="text" placeholder="Username">
                <input type="password" placeholder="Password">
            </form>
        </div>
    </header>
</body>
</html>
