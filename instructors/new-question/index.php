<?php
session_start();
if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false)
    header("location: /");

require_once($_SERVER['DOCUMENT_ROOT'] . "/srv_utils/dbconfig.php");
$userguid = (int)$_SESSION['guid'];

if(isset($_POST['submit'])) {
    $question_name = $_POST['qname'];
    $question_prompt = $_POST['question-prompt'];
    $skeleton = $_POST['question-skeleton'];
    $correct_output = $_POST['question-output'];
    $question_lang = $_POST[''];

    mysqli_query($con, "INSERT INTO `courses`.`saved-questions` (`Question Owner`, `Question Name`, `Question Prompt`, `Question Skeleton`, `Code Language`, `Question Tests`, `Question Validation`) VALUES ($userguid, $question_name,$question_prompt,$skeleton,'Python','',$correct_output);");
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
    <link rel="stylesheet" href="./question-bank.css" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
</head>
    <body>
    <?php 
    require_once($_SERVER['DOCUMENT_ROOT'] . "/common/header-internal.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/common/sidebar-left.php");

    $saved_questions_query = mysqli_query($con, "SELECT `Question ID`, `Question Name`, `Question Prompt`, `Question Skeleton`, `Code Language` FROM `courses`.`saved-questions` WHERE `Question Owner` = $userguid AND `Banked` = true;");
    $saved_questions = [];
    while($question = mysqli_fetch_array($saved_questions_query))
        $questions[] = $question;

    $langs_avail_query = mysqli_query($con, "SELECT `Human-readable` FROM `courses`.`languages-avail`;");
    $langs_avail = [];
    while($lang = mysqli_fetch_array($langs_avail_query))
        $langs_avail[] = $lang[0];
    ?>
    <!--<div class="section-menu"></div>-->
    <div class="section-main">
        <h2>Question Bank</h2>
        <div class="subsection-level1">
            <form method=post>
                <input type="text" name="qname" placeholder="(enter question title here)" size="50">

                <label for=lang>Language for Code: </label>
                <select name="lang" id="program-lang">
                    <?php
                    foreach($langs_avail as $lang)
                        echo "<option value=\"$lang\">$lang</option>";
                    ?>
                </select>

                <label for=question-prompt>Question Prompt</label>
                <textarea id="prompt" name="question-prompt" placeholder="(please enter your question prompt here)" style="height: 7em;""></textarea>

                <label for=question-skeleton>Question Skeleton Code</label>
                <textarea id="skeleton" name="question-skeleton" placeholder="Question Skeleton" style="height: 15em;"></textarea>

                <label for=question-arguments>Program Arguments:</label>
                <textarea id="question-arguments" name="question-arguments" placeholder="(please enter your arguments here)" style="height: 7em;"></textarea>

                <label for=question-correctoutput>Correct Output</label> <br>
                <textarea id="output" name="question-output" placeholder="Output" style="height: 7em;"></textarea>

                <button type="submit" name="submit">Submit</span></button>
            </form>
        </div>
    </div>
    <div id="sidebar-right">
        <h2>Stored</h2>
        <?php
        if(empty($questions)) {
            echo("No banked questions");
        } else {
            foreach($questions as $question) {
                echo <<< EOT
                <div class="qitem">
                    <div class="qitem-name">$question[1]</div>
                    <div class="qitem-lang">$question[4]</div>
                </div>
                EOT;
            }
        }
        ?>
    </div>
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/common/footer.php"); ?>
</body>
</html>