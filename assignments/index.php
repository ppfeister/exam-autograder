<?php
session_start();
if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false || !isset($_GET['aid']))
    header("location: /index.php");
$req_aid = $_GET["aid"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Coding examination website with automatic grading of student-submitted code">
    <title>bitlab - Student Coding Lab</title>
    <link rel="stylesheet" href="../styles/master.css" type="text/css">
    <link rel="stylesheet" href="assignments.css" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
</head>
<body>
<script src="/scripts/ace/ace.js" type="text/javascript" charset="utf-8"></script>
<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/common/header-internal.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/common/sidebar-left.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/srv_utils/dbconfig.php");

$userguid = $_SESSION['guid'];
$assignment_info = mysqli_fetch_array(mysqli_query($con, "SELECT course.`Course Code`, assignments.`Assignment name`, assignments.`Allow resubmit` from `courses`.`assignments` as assignments INNER JOIN `courses`.`available-courses` as course INNER JOIN `courses`.`course-membership` as membership WHERE assignments.`Assignment ID` = $req_aid AND assignments.`Course GUID` = membership.`Course GUID` = course.`Course GUID` AND membership.`Member GUID` = $userguid;"));
$assignment_query = mysqli_query($con, "SELECT assignments.`Assignment ID`, assignments.`Assignment name`, course.`Course Code`, qset.`Question ID`, qset.`Points`, questions.`Question Name`, questions.`Question Prompt`, questions.`Question Skeleton`, questions.`Code Language`, languages.`Ace`, questions.`Question Tests`, questions.`Question Validation` from `courses`.`assignments` as assignments INNER JOIN `courses`.`available-courses` as course INNER JOIN `courses`.`course-membership` as membership INNER JOIN `courses`.`languages-avail` as languages INNER JOIN `courses`.`question-sets` as qset INNER JOIN `courses`.`saved-questions` as questions WHERE assignments.`Assignment ID` = qset.`Assignment ID` AND assignments.`Assignment ID` = $req_aid AND assignments.`Course GUID` = membership.`Course GUID` = course.`Course GUID` AND membership.`Member GUID` = $userguid AND qset.`Question ID` = questions.`Question ID` AND questions.`Code Language` = languages.`Human-readable`;");
$questions = [];
while($question = mysqli_fetch_array($assignment_query))
    $questions[] = $question;
?>

<div id="content-wrapper">
    <div class="section-main">
        <?php
        if(empty($assignment_info)) // TODO: Improve no-assignment failsafe
            header("location: /index.php");
        echo("<h2>" . $assignment_info[0] . " - " . $assignment_info[1] . "</h2>");
        if(empty($questions)) { // TODO: Improve no-questions failsafe
            echo("There was a problem.");
        } else {
            foreach ($questions as $question) {
                $current_score = 0;
                $allow_resub = true;
                $previous_answer_query = mysqli_query($con, "SELECT `Answer`, `Score` FROM `courses`.`submitted-answers` WHERE `Assignment ID` = $question[0] AND `Question ID` = $question[3] AND `Member GUID` = $userguid;");
                if(mysqli_num_rows($previous_answer_query)) {
                    $prev_question_data =  mysqli_fetch_array($previous_answer_query);
                    $question[7] = $prev_question_data[0];
                    $current_score = $prev_question_data[1];
                    if(!$assignment_info[2])
                        $allow_resub = false;
                }
                echo <<< EOT
        <div class="subsection-level1">
            <p class="assignment-desc">$question[6]</p>
            <div class="question-options">
                <span style="grid-area: left-fill;"></span>
                <!--<span style="grid-area: right-fill;"></span>-->
                <!--<a href="#" style="grid-area: reset;" title="Revert to skeleton"><span class="material-icons-sharp">restart_alt</span></a>-->
                <span class="question-score">$current_score / $question[4] points</span>
                <a href="#" style="grid-area: stop;" title="Abort"><span class="material-icons-sharp">stop</span></a>
                <a href="#" style="grid-area: run;" title="Run"><span class="material-icons-sharp">play_arrow</span></a>
                <!--<a href="/assignments?aid=000001,q=1" style="grid-area: next-q-submit;" title="Next question">Next <span class="material-icons-sharp">arrow_forward</span></a>-->
                <a href="#" onclick="submit_q$question[3]()" style="grid-area: next-q-submit;" title="Submit assignment">Submit <span class="material-icons-sharp">done</span></a>
            </div>
            <div id="editor-$question[3]" style="min-height: 25em;">$question[7]</div>
        </div>
        <script>
            var editor_$question[3] = ace.edit("editor-$question[3]");
            editor_$question[3].setShowPrintMargin(false);
            editor_$question[3].setTheme("ace/theme/eclipse");
            editor_$question[3].session.setMode("ace/mode/$question[9]");
            editor_$question[3].setReadOnly(!$allow_resub);
            
            function submit_q$question[3]() {
                var ajax = new XMLHttpRequest();
                var data = [$question[0], $question[3], JSON.stringify(editor_$question[3].getValue())];
                ajax.open("POST", "./submit-answer.php");
                ajax.setRequestHeader("Content-type", "application/json");
                ajax.send(JSON.stringify(data));
            }
        </script>
EOT;

            }
        }
        ?>
    </div>
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/common/footer.php"); ?>
</div>

<!----- EDITOR ----->

<!----- EDITOR ----->

</body>
</html>
