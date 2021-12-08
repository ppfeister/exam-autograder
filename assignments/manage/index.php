<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/srv_utils/dbconfig.php");

session_start();
if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false || !isset($_GET['aid']))
    header("location: /index.php");
$req_aid = $_GET["aid"];
$userguid = $_SESSION['guid'];

$user_role = mysqli_fetch_array(mysqli_query($con, "SELECT membership.`Role` FROM `courses`.`course-membership` as membership INNER JOIN `courses`.`assignments` as assignments WHERE membership.`Member GUID` = $userguid AND assignments.`Assignment ID` = $req_aid AND membership.`Course GUID` = assignments.`Course GUID`;"))[0];
if($user_role != 1 && $user_role != 2) // if user is not an instructor or TA, block access and redirect to home
    header("location: /index.php");
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

$assignment_info = mysqli_fetch_array(mysqli_query($con, "SELECT course.`Course Code`, assignments.`Assignment name`, assignments.`Allow resubmit` from `courses`.`assignments` as assignments INNER JOIN `courses`.`available-courses` as course INNER JOIN `courses`.`course-membership` as membership WHERE assignments.`Assignment ID` = $req_aid AND assignments.`Course GUID` = membership.`Course GUID` = course.`Course GUID` AND membership.`Member GUID` = $userguid;"));
$members = [];
$members_query = mysqli_query($con, "SELECT membership.`Member GUID`, users.`First name`, users.`Last name` FROM `courses`.`course-membership` as membership INNER JOIN `bitlab`.`users` as users INNER JOIN `courses`.`assignments` as assignments WHERE users.`GUID` = membership.`Member GUID` AND membership.`Role` = 0 AND assignments.`Assignment ID` = $req_aid AND assignments.`Course GUID` = membership.`Course GUID`;");
while($member = mysqli_fetch_array($members_query))
    $members[] = $member;
?>

<div id="content-wrapper">
    <div class="section-main">
        <?php
        if(empty($assignment_info)) // TODO: Improve no-assignment failsafe
            header("location: /index.php");
        echo("<h2>" . $assignment_info[0] . " - " . $assignment_info[1] . "</h2>");
        ?>
        <div class="subsection-level1">
            <div> Name: Grade </div>
            <div> Name: Grade </div>
            <div> Name: Grade </div>
        </div>
    </div>
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/common/footer.php"); ?>
</div>

<!----- EDITOR ----->

<!----- EDITOR ----->

</body>
</html>