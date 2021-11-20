<?php
session_start();
if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false)
    header("location: /index.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Coding examination website with automatic grading of student-submitted code">
    <title>bitlab - Student Coding Lab</title>
    <link rel="stylesheet" href="../styles/master.css" type="text/css">
    <link rel="stylesheet" href="user-home.css" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
</head>
<body>
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/common/header-internal.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/common/sidebar-left.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/srv_utils/dbconfig.php");

    $userguid = $_SESSION['guid'];
    $courses_query = mysqli_query($con, "SELECT courses.`Course GUID`, courses.`Course Code`, courses.`Course Name`, membership.`Role` FROM `bitlab`.`users` as accounts INNER JOIN `courses`.`course-membership` as membership ON membership.`Member GUID` = accounts.`GUID` INNER JOIN `courses`.`available-courses` as courses ON membership.`Course GUID` = courses.`Course GUID` WHERE accounts.`GUID` = $userguid;");
    $courses = [];
    while($course = mysqli_fetch_array($courses_query))
        $courses[] = $course;
    ?>

    <div class="section-main">
        <h2>Assigned courses</h2>
        <?php
        if(empty($courses)) {
            echo("No courses assigned");
        } else {
            foreach($courses as $course){
                $assignments = [];
                $assignment_query = mysqli_query($con, "SELECT `Assignment ID`, `Assignment name`, `Date opened`, `Date closed` FROM courses.assignments WHERE `Course GUID` = $course[0];");
                while($assignment = mysqli_fetch_array($assignment_query))
                    $assignments[] = $assignment;
                echo <<< EOT
                    <div class="subsection-level1">
                        <h3>$course[1] - $course[2]</h3>
                        <div class="course-assignment-list">
                EOT;
                foreach($assignments as $assignment)
                    echo <<< EOT
                            <div class="assignment-listing">
                                <span class="assignment-name">$assignment[1]</span>
                                <span class="assignment-desc"></span>
                                <span class="assignment-duedate">$assignment[3]<span class="material-icons-sharp status-icon">task</span></span>
                            </div>
                    EOT;
                echo <<< EOT
                        </div>
                    </div>
                EOT;
            }
        }
        require_once('../common/footer.php'); ?>
    </div>
</body>
</html>
