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
    <link rel="stylesheet" href="../../styles/master.css" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
</head>
    <body>
    <?php 
    require_once($_SERVER['DOCUMENT_ROOT'] . "/common/header-internal.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/common/sidebar-left.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/srv_utils/dbconfig.php"); 
    
    $assignment_info = mysqli_fetch_array(mysqli_query($con, "SELECT course.`Course Code`, assignments.`Assignment name`, assignments.`Allow resubmit` from `courses`.`assignments` as assignments INNER JOIN `courses`.`available-courses` as course INNER JOIN `courses`.`course-membership` as membership WHERE assignments.`Assignment ID` = $req_aid AND assignments.`Course GUID` = membership.`Course GUID` = course.`Course GUID` AND membership.`Member GUID` = $userguid;"));
    $assignment_query = mysqli_query($con, "SELECT assignments.`Assignment ID`, assignments.`Assignment name`, course.`Course Code`, qset.`Question ID`, qset.`Points`, questions.`Question Name`, questions.`Question Prompt`, questions.`Question Skeleton`, questions.`Code Language`, languages.`Ace`, questions.`Question Tests`, questions.`Question Validation` from `courses`.`assignments` as assignments INNER JOIN `courses`.`available-courses` as course INNER JOIN `courses`.`course-membership` as membership INNER JOIN `courses`.`languages-avail` as languages INNER JOIN `courses`.`question-sets` as qset INNER JOIN `courses`.`saved-questions` as questions WHERE assignments.`Assignment ID` = qset.`Assignment ID` AND assignments.`Assignment ID` = $req_aid AND assignments.`Course GUID` = membership.`Course GUID` = course.`Course GUID` AND membership.`Member GUID` = $userguid AND qset.`Question ID` = questions.`Question ID` AND questions.`Code Language` = languages.`Human-readable`;");
    $questions = [];
    while($question = mysqli_fetch_array($assignment_query)) {
        $questions[] = $question;
    }
    ?>
    <!--<div class="section-menu"></div>-->	
	
    <div class="split left">
        <div class="section-main">
            <div class="subsection-level1">
                <h3>Setup New Question</h3>
                <form method=post>
                    <label for=question-prompt>Question Prompt:</label>
                    <input class="textbox-small" id="question-prompt" type="text">
                    <br> 
                    <label for=lang>Language for Code: </label><select name="lang" id="pro-lang">
                        <option value="lang1">Assembly</option>
                        <option value="lang2">LISP</option>
                    </select>
                    <br>
                    <label for=question-skeleton>Question Skeleton Code</label> <br>
                    <textarea class=textarea id="skeleton" name="question-skeleton"> </textarea>
                    <br>
                </form>            
            </div>
            <div class="subsection-level1">
                <form method=post>
                    <label for=question-arguments>Program Arguments:</label>
                    <input class="textbox-small" id="question-arguments" type="text">

                    <br> <label for=question-correctoutput>Correct Output</label> <br>
                    <textarea class=textarea id="output" name="question-output"> </textarea>
                </form>
            </div>
        </div>
        
    </div>
    <div class="split right">
        <div class="section-main">
            <h3>Question Bank</h3>
            <div class=sidebar-left>

            </div>
        </div>
    </div>
	
    <?php require_once('../common/footer.php'); ?>
</body>
</html>