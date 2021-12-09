<?php
session_start();
if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false)
    header("location: /index.php");
$req_courseid = (int)$_GET["cid"];

require_once($_SERVER['DOCUMENT_ROOT'] . "/srv_utils/dbconfig.php");

if(isset($_POST['submit'])) {
    $form_name = $_POST['assignment-name'];
    $form_resub = 0;
    if($_POST['allow-resubmit'] == "on")
        $form_resub = 1;
    $questions_submitted = $_POST['questions'];

    mysqli_query($con, "INSERT INTO `courses`.`assignments` (`Course GUID`, `Assignment name`, `Allow resubmit`) VALUES ($req_courseid, \"$form_name\", $form_resub);");
    $new_assignment_id = $con->insert_id;
    foreach ($questions_submitted as $qid) {
        $qid = (int)$qid;
        mysqli_query($con, "INSERT INTO `courses`.`question-sets` (`Assignment ID`, `Question ID`, `Points`) VALUES ($new_assignment_id, $qid, 5);");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Coding examination website with automatic grading of student-submitted code">
    <title>bitlab - Student Coding Lab</title>
    <link rel="stylesheet" href="../../styles/master.css" type="text/css">
    <link rel="stylesheet" href="./new-assignment.css" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
</head>
<body>
<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/common/header-internal.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/common/sidebar-left.php");

$userguid = $_SESSION['guid'];

$questions_query = mysqli_query($con, "SELECT `Question ID`, `Question Name`, `Question Prompt`, `Question Skeleton`, `Code Language` FROM `courses`.`saved-questions` WHERE `Question Owner` = $userguid AND `Banked` = true;");
while($question = mysqli_fetch_array($questions_query))
    $questions[] = $question;
?>

<div id="content-wrapper">
    <div class="section-main">
        <h2>CS 490 - New assignment</h2>
        <div class="subsection-level1">
            <form id="new-assignment-form" method="post">
                <label for="assignment-name" style="grid-area: name-label;">Assignment name:</label>
                <input type="text" id="assignment-name" placeholder="Hello World" style="grid-area: name-field;" name="assignment-name">
                <label for="allow-resubmit" style="grid-area: resub-label;">Allow resubmissions?</label>
                <input type="checkbox" id="allow-resubmit" checked style="grid-area: resub-field;" name="allow-resubmit">
                <label for="question-selection" style="grid-area: questions-label;">Questions:</label>
                <div id="question-selection" style="grid-area: questions-field;">
                    <?php

                    // original code for question population, use if below code doesn't work
                    // echo <<< EOT
                    //<input type="checkbox" id="qid-$question[0]" name="questions[]" value="$question[0]">
                    //<label>$question[1]</label>
                    //EOT;
                    foreach ($questions as $question){
                        echo <<< EOT
                        <input type="checkbox" id="qid-$question[0]" name="questions[]" value="$question[0]">
                        <label>$question[1], $question[1] pts:</label>
                        <input type="text" id="qid-$question[3]",style="grid-area: name-field", name="$question[3]"> 
                        EOT;
                    }
                    ?>
                </div>
                <div style="grid-area: right-fill;"></div>
            </form>
            <button type="submit" form="new-assignment-form" value="submit" name="submit">Create assignment</button>
        
        </div>
    </div>
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/common/footer.php"); ?>
</div>

<!----- EDITOR ----->

<!----- EDITOR ----->

</body>
</html>