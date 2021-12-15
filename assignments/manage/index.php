<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/srv_utils/dbconfig.php");

session_start();
if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false || !isset($_GET['aid']))
    header("location: /index.php");
$req_aid = $_GET["aid"];
$userguid = $_SESSION['guid'];

$user_role = mysqli_fetch_array(mysqli_query($con, "SELECT membership.`Role` FROM `courses`.`course-membership` as membership INNER JOIN `courses`.`assignments` as assignments WHERE membership.`Member GUID` = '$userguid' AND assignments.`Assignment ID` = '$req_aid' AND membership.`Course GUID` = assignments.`Course GUID`;"))[0];

if($user_role != 1 && $user_role != 2) // if user is not an instructor or TA, block access and redirect to home
    header("location: /index.php");

if(isset($_POST['submit'])) {
    $student = $_POST['student_guid'];
    $aid = $_POST['aid'];
    $qid = $_POST['qid'];
    $score = $_POST['corrected_score'];

    mysqli_query($con, "UPDATE `courses`.`submitted-answers` SET `Corrected Score` = '$score' WHERE `Assignment ID` = '$aid' AND `Question ID` = '$qid' AND `Member GUID` = '$student';");
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
    <link rel="stylesheet" href="./management.css" type="text/css">
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

$possible_points = 0;
$questions = [];
$questions_query = mysqli_query($con, "SELECT a.`Question ID`, a.`Question Name`, a.`Question Prompt`, p.`Points` FROM `courses`.`saved-questions` as a INNER JOIN `courses`.`question-sets` as p WHERE p.`Assignment ID` = $req_aid AND p.`Question ID` = a.`Question ID`;");
while($question = mysqli_fetch_array($questions_query)) {
    $questions[] = $question;
    $possible_points += $question['Points'];
}
?>

<div id="content-wrapper">
    <div class="section-main">
        <?php
        if(empty($assignment_info)) // TODO: Improve no-assignment failsafe
            header("location: /index.php");
        echo("<h2>" . $assignment_info[0] . " - " . $assignment_info[1] . "</h2>");
        ?>
        <div class="subsection-level1">
            <?php
            foreach ($members as $member) {
                $answers = [];
                $answers_query = mysqli_query($con, "SELECT `Question ID`, `Answer`, `Score`, `Corrected Score` FROM `courses`.`submitted-answers` WHERE `Assignment ID` = $req_aid AND `Member GUID` = $member[0];");
                $member_points = 0;
                $member_corrected_points = 0;
                while($answer = mysqli_fetch_array($answers_query)) {
                    $answers[$answer[0]] = $answer;
                    $member_points += $answer['Score'];
                    if($answer['Corrected Score'] != "")
                        $member_corrected_points += $answer['Corrected Score'];
                    else
                        $member_corrected_points += $answer['Score'];
                }
                $bitlab_percent = number_format($member_points / $possible_points * 100, 0);
                $corrected_percent = number_format($member_corrected_points / $possible_points * 100, 0);
                echo <<< EOT
                <div class="student-header">
                    <span class="student-name" style="grid-area: stu-name">$member[1] $member[2]</span>
                    <span class="student-grade" style="grid-area: stu-bitlab-grade">bitlab Grade: $bitlab_percent% ($member_points/$possible_points)</span>
                    <span class="instructor-grade" style="grid-area: stu-corrected-grade">Corrected Grade: $corrected_percent% ($member_corrected_points/$possible_points)</span>
                </div>
                <div class="student-info">
                    <div class="content">
                EOT;

                foreach ($questions as $question) {
                    $stu_answers = "Not yet completed";
                    $stu_grade = "No grade";
                    $stu_cor_grade = null;
                    if(isset($answers[$question[0]])) {
                        $stu_answers = $answers[$question[0]][1];
                        $stu_grade = $answers[$question[0]][2];
                        $stu_cor_grade = $answers[$question[0]][3];
                    }
                    echo <<< EOT
                    <div class="question-row">
                        <div class="question-col" style="grid-area: question">
                            <span class="qsection-title"><b>$question[1]</b></span>
                            <div class="question-prompt">$question[2]</div>
                        </div>
                        <div class="answer-col" style="grid-area: answer">
                            <span class="qsection-title"><b>Submitted:</b></span>
                            <div class="student-answer">$stu_answers</div>
                        </div>
                        <div class="grade-col" style="grid-area: grades">
                            $question[3] points available<br>
                            bitlab Grade: $stu_grade<br>
                            <form id="score-correction-$question[0]" method="post">
                                <label for="student_guid">New grade: </label>
                                <input type="number" min="0" max="$question[3]" step="0.01" name="corrected_score" value="$stu_cor_grade">
                                <input type="hidden" value="$member[0]" name="student_guid">
                                <input type="hidden" value="$req_aid" name="aid">
                                <input type="hidden" value="$question[0]" name="qid">
                            </form>
                            <button type="submit" form="score-correction-$question[0]" value="submit" name="submit"><span class="material-icons-sharp score-button-icon">sync</span></button>
                        </div>
                    </div>
                    EOT;
                }
                echo <<< EOT
                    </div>
                </div>
                EOT;
            }
            ?>
            <script type="text/javascript">
                student_blocks = document.getElementsByClassName("student-header");

                for(var i = 0; i < student_blocks.length; i++ ) {
                    student_blocks[i].addEventListener("click", function() {
                        this.classList.toggle("active");
                        var student_info = this.nextElementSibling;
                        if(student_info.style.maxHeight)
                            student_info.style.maxHeight = null;
                        else
                            student_info.style.maxHeight = student_info.scrollHeight + "px";
                    });
                }
            </script>
        </div>
    </div>
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/common/footer.php"); ?>
</div>

<!----- EDITOR ----->

<!----- EDITOR ----->

</body>
</html>