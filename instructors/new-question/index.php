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
    ?>
    <!--<div class="section-menu"></div>-->	
	
    <div class="split left">
        <div class="section-main">
            <div class="subsection-level1">
                <h3>Basic Setup</h3>
                <form method=post>
                    <label for=question-prompt>Question Prompt</label> <br>
                    <textarea id="prompt" name="question-prompt" placeholder="(please enter your question prompt here)" rows="4" cols="50">
                
                    </textarea>
                    <br> 
                    <label for=lang>Language for Code: </label><select name="lang" id="pro-lang">
                        <option value="lang1">Assembly</option>
                        <option value="lang2">LISP</option>
                    </select>
                    <br>
                    <label for=question-skeleton>Question Skeleton Code</label> <br>
                    <textarea id="skeleton" name="question-skeleton" placeholder="Question Skeleton" rows="4" cols="50">
                
                    </textarea>
                    <br>
                </form>            
            </div>
            <div class="subsection-level1">
                <h3>Advanced Setup</h3>
                <form method=post>
                    <label for=question-arguments>Program Arguments:</label>
                    <input type="text" name="question-arguments" placeholder="(please enter your arguments here)" size="45">

                    <br> <label for=question-correctoutput>Correct Output</label> <br>
                    <textarea id="output" name="question-output" placeholder="Output" rows="4" cols="50">
                
                    </textarea>
                </form>
            </div>
        </div>
        
    </div>
    <div class="split right">
        <div class="section-main">
            <h3>Question Bank</h3>
        </div>
    </div>
	
    <?php require_once('../common/footer.php'); ?>
</body>
</html>