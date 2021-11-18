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
    <?php require_once('../../common/header-internal.php'); ?>
    <!--<div class="section-menu"></div>-->	
	<div class="section-main">
	    <h2>Prepare new questions</h2>
        <div class="subsection-level1 first-item">
            <h3>Help and info</h3>
            <span>Creating new assignments can be quicker and easier when regularly-used questions are already stored here.</span>
        </div>
        <div class="subsection-level1">
            <h3>New Question:</h3>
            <form>
                <label for="difficulty">Select question difficulty:</label>
                <select id="difficulty">
                    <option value="easy">Easy</option>
                    <option value="medium">Medium</option>
                    <option value="hard">Hard</option>
                </select><br><br>
                
                <label for="category">Select question category:</label>
                <select id="category">
                    <option value="general">General</option>
                    <option value="for-loop">For Loop</option>
                    <option value="while-loop">While Loop</option>
                    <option value="recursion">Recursion</option>
                    <option value="return">Return</option>
                </select><br><br>
                
                <label for="question-text">Enter question prompt:</label><br>
                <textarea id="questionText" rows="10" cols="80">
                </textarea><br><br>
                
                <hr>
                
                <h3>Answer Requirements:</h3>
                
                <label for="function-name">Function Name:</label><br>
                <input id="function-name" type="text" size="35"></textarea>
                <br><br>
                
                <label for="parameter-name">Parameter(s) </label><small>(comma separated):</small><br>
                <input id="parameters-name" type="text" size="35"></textarea>
                <br><br>
                
                <h3>Test Cases:</h3>
                
                <label for="parameter-value">Parameter Value(s) </label><small>(comma separated):</small><br>
                <input id="parameter-value" type="text" size="35"></textarea>
                <br><br>
                
                <label for="output">Output </label><br>
                <input id="output" type="text" size="35"></textarea>
                <br><br>
                
            </form>
        </div>
	</div>
    <?php require_once('../common/footer.php'); ?>
</body>
</html>