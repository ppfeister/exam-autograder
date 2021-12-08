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
    <div id="content-wrapper">
        <div class="section-main">
            <h2>Assigned courses</h2>
            <?php
            if(empty($courses)) {
                echo("No courses assigned");
            } else {
                foreach($courses as $course) {
                    $assignments = [];
                    $assignment_query = mysqli_query($con, "SELECT `Assignment ID`, `Assignment name`, `Date opened`, `Date closed` FROM courses.assignments WHERE `Course GUID` = $course[0];");
                    while($assignment = mysqli_fetch_array($assignment_query))
                        $assignments[] = $assignment;
                    echo "<div class=\"subsection-level1\">
                            <h3>$course[1] - $course[2]</h3>";
                    if($course[3] == 2)
                        require_once($_SERVER['DOCUMENT_ROOT'] . "/assignments/instructor-toolbar.php");
                    echo "<div class=\"course-assignment-list\">";
                    foreach($assignments as $assignment) {
                        if($course[3] != 2) {
                            $assignment_grade_query = mysqli_query($con, "SELECT submitted.`Score`, submitted.`Corrected Score`, qsets.`Points` FROM `courses`.`submitted-answers` as submitted INNER JOIN `courses`.`question-sets` as qsets WHERE submitted.`Assignment ID` = $assignment[0] AND submitted.`Member GUID` = $userguid AND qsets.`Assignment ID` = submitted.`Assignment ID` AND qsets.`Question ID` = submitted.`Question ID`;");
                            $assignment_grade[0] = 0;
                            $assignment_grade[1] = 0;
                            while ($question_grades = mysqli_fetch_array($assignment_grade_query)) {
                                if ($question_grades[1] !== null)
                                    $assignment_grade[0] += $question_grades[1];
                                else
                                    $assignment_grade[0] += $question_grades[0];
                                $assignment_grade[1] += $question_grades[2];
                            }
                        }
                        if($course[3] != 2)
                            echo "<a href=\"/assignments/?aid=$assignment[0]\">";
                        else
                            echo "<a href=\"/assignments/manage/?aid=$assignment[0]\">";
                        echo <<< EOT
                                    <div class="assignment-listing">
                                        <span class="assignment-name">$assignment[1]</span>
                                        <span class="assignment-data">
                        EOT;
                        if($course[3] != 2)
                            echo "<span class=\"assignment-score\">$assignment_grade[0] / $assignment_grade[1]</span>";
                        echo <<< EOT
                                            <span class="assignment-duedate">$assignment[3]<span class="material-icons-sharp status-icon">task</span></span>
                                        </span>
                                    </div>
                                </a>
                        EOT;
                    }
                    echo <<< EOT
                            </div>
                        </div>
                    EOT;
                }
            }
            ?>
        </div>
        <?php require_once('../common/footer.php'); ?>
    </div>
</body>
</html>
