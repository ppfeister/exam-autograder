<?php
session_start();
if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false || !isset($_GET['cid']))
    header("location: /index.php");
$req_courseid = $_GET["cid"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Coding examination website with automatic grading of student-submitted code">
    <title>bitlab - Student Coding Lab</title>
    <link rel="stylesheet" href="../../styles/master.css" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
</head>
<body>
<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/common/header-internal.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/common/sidebar-left.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/srv_utils/dbconfig.php");

$userguid = $_SESSION['guid'];
?>

<div id="content-wrapper">
    <div class="section-main">
        <div class="subsection-level1">
            <h2>Student Grades</h2>
            <div> Name: Grade </div>
            <div> Name: Grade </div>
            <div> Name: Grade </div>
        </div>
    </div>
    <?php require_once('../common/footer.php'); ?>
</div>

<!----- EDITOR ----->

<!----- EDITOR ----->

</body>
</html>