<?php
session_start();
if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false)
    header("location: /");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Coding examination website with automatic grading of student-submitted code">
    <title>bitlab - Student Coding Lab</title>
    <link rel="stylesheet" href="../styles/master.css" type="text/css">
    <link rel="stylesheet" href="courses.css" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
</head>
<body>
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/common/header-internal.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/srv_utils/dbconfig.php");

    $userguid = $_SESSION['guid'];
    $query = mysqli_query($con, "SELECT courses.`Course GUID`, courses.`Course Code`, courses.`Course Name`, assignments.`Assignment ID`, assignments.`Assignment Name`, assignments.`Date opened`, assignments.`Date closed` FROM `bitlab`.`users` as accounts INNER JOIN `courses`.`course-membership` as membership ON membership.`Member GUID` = accounts.`GUID` INNER JOIN `courses`.`available-courses` as courses ON membership.`Course GUID` = courses.`Course GUID` INNER JOIN `courses`.`assignments` as assignments ON assignments.`Course GUID` = membership.`Course GUID` WHERE accounts.`GUID` = $userguid;");
    $login_query_result = mysqli_fetch_assoc($query);
    echo($login_query_result);
    ?>
    <!--<div class="section-menu"></div>-->
    <div class="section-main">
        <h2>Assigned courses</h2>
        <div class="subsection-level1 first-item">
            <div class="subsection-level1-info">
                <span class="subsection-level1-name">CS 490 - Design in Software Engineering</span>
            </div>
            <div class="course-assignment-list">
                <div class="assignment-listing">
                    <span class="assignment-name">Milestone 1</span>
                    <span class="assignment-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit</span>
                    <span class="assignment-duedate">Oct 20, 2021 11:59pm<span class="material-icons-sharp status-icon">task</span></span>
                </div>
                <div class="assignment-listing">
                    <span class="assignment-name">Milestone 1</span>
                    <span class="assignment-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit</span>
                    <span class="assignment-duedate status-icon">Oct 20, 2021 11:59pm<span class="material-icons-sharp status-icon">task</span></span>
                </div>
                <div class="assignment-listing">
                    <span class="assignment-name">Milestone 1</span>
                    <span class="assignment-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit</span>
                    <span class="assignment-duedate">Oct 20, 2021 11:59pm<span class="material-icons-sharp status-icon">hourglass_bottom</span></span>
                </div>
            </div>
        </div>
        <div class="subsection-level1">
            <div class="subsection-level1-info">
                <span class="subsection-level1-name">CS 490 - Design in Software Engineering</span>
            </div>
            <div class="course-assignment-list">
                <div class="assignment-listing">
                    <span class="assignment-name">Milestone 1</span>
                    <span class="assignment-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit</span>
                    <span class="assignment-duedate">Oct 20, 2021 11:59pm<span class="material-icons-sharp status-icon">task</span></span>
                </div>
                <div class="assignment-listing">
                    <span class="assignment-name">Milestone 1</span>
                    <span class="assignment-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit</span>
                    <span class="assignment-duedate status-icon">Oct 20, 2021 11:59pm<span class="material-icons-sharp status-icon">task</span></span>
                </div>
                <div class="assignment-listing">
                    <span class="assignment-name">Milestone 1</span>
                    <span class="assignment-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit</span>
                    <span class="assignment-duedate">Oct 20, 2021 11:59pm<span class="material-icons-sharp status-icon">hourglass_bottom</span></span>
                </div>
            </div>
        </div>
        <div class="subsection-level1">
            <div class="subsection-level1-info">
                <span class="subsection-level1-name">CS 490 - Design in Software Engineering</span>
            </div>
            <div class="course-assignment-list">
                <div class="assignment-listing">
                    <span class="assignment-name">Milestone 1</span>
                    <span class="assignment-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit</span>
                    <span class="assignment-duedate">Oct 20, 2021 11:59pm<span class="material-icons-sharp status-icon">task</span></span>
                </div>
                <div class="assignment-listing">
                    <span class="assignment-name">Milestone 1</span>
                    <span class="assignment-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit</span>
                    <span class="assignment-duedate status-icon">Oct 20, 2021 11:59pm<span class="material-icons-sharp status-icon">task</span></span>
                </div>
                <div class="assignment-listing">
                    <span class="assignment-name">Milestone 1</span>
                    <span class="assignment-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit</span>
                    <span class="assignment-duedate">Oct 20, 2021 11:59pm<span class="material-icons-sharp status-icon">hourglass_bottom</span></span>
                </div>
            </div>
        </div>
    </div>
    <?php require_once('../common/footer.php'); ?>
</body>
</html>
