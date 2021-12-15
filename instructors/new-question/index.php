<?php
session_start();
if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false)
    header("location: /");

require_once($_SERVER['DOCUMENT_ROOT'] . "/srv_utils/dbconfig.php");
$userguid = (int)$_SESSION['guid'];

if(isset($_POST['update'])) {
    $qid = $_POST['qid-selected'];
    mysqli_query($con, "UPDATE `courses`.`saved-questions` SET `Banked` = 0 WHERE `Question ID` = $qid AND `Question Owner` = $userguid;") or die(mysqli_error($con));
}

if(isset($_POST['submit']) || isset($_POST['update'])) {
    $question_name = $_POST['qname'];
    $question_prompt = $_POST['question-prompt'];
    $skeleton = $_POST['question-skeleton'];
    $question_lang = $_POST['lang'];
    $tests = $_POST['testcases'];
    
    mysqli_query($con, "INSERT INTO `courses`.`saved-questions` (`Question Owner`, `Banked`, `Question Name`, `Question Prompt`, `Question Skeleton`, `Code Language`) VALUES ('$userguid', true, '$question_name','$question_prompt','$skeleton','$question_lang');") or die(mysqli_error($con));
    $new_qid = $con->insert_id;
    
    foreach($tests as $test) {
        if($test['args'] == "" && $test['expected_out'] == "")
            continue;
        $args = $test['args'];
        $expected = $test['expected_out'];
        mysqli_query($con, "INSERT INTO `courses`.`saved-test-cases` (`Question ID`, `Arguments`, `Expected output`) VALUES ('$new_qid', '$args', '$expected');") or die(mysqli_error($con));
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
    <link rel="stylesheet" href="./question-bank.css" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <script src="/scripts/delete-question.js" type="text/javascript" charset="utf-8"></script>
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
            <form id="qbank-form" method=post>
                <label style="grid-area: name-label;" for="qname">Question name</label>
                <input style="grid-area: name-field;" type="text" name="qname" id="qname" placeholder="Hello World..." size="50">

                <label style="grid-area: lang-label;" for=lang>Code language</label>
                <select style="grid-area: lang-field;" name="lang" id="program-lang"><?php foreach($langs_avail as $lang) echo "<option value=\"$lang\">$lang</option>"; ?></select>
                
                <label style="grid-area: prompt-label;" for=question-prompt>Question prompt</label>
                <textarea style="grid-area: prompt-field; height: 7em;" id="prompt" name="question-prompt" placeholder="Print Hello World to the console"></textarea>

                <label style="grid-area: skel-label;" for=question-skeleton>Skeleton code</label>
                <textarea style="grid-area: skel-field; height: 15em;" id="skeleton" name="question-skeleton" placeholder="Question Skeleton"></textarea>

                <!--<label style="grid-area: arg-label" for=question-arguments>Program Arguments:</label>
                <textarea style="grid-area: lang-label" id="question-arguments" name="question-arguments" placeholder="(please enter your arguments here)" style="height: 7em;"></textarea>

                <label style="grid-area: lang-label" for=question-correctoutput>Correct Output</label>
                <textarea style="grid-area: lang-label" id="output" name="question-output" placeholder="Output" style="height: 7em;"></textarea>-->

                <label style="grid-area: testcases-label;">Test cases</label>
                <div class="testcases-fields" style="grid-area: testcases-fields;">
                    <input id="test0" style="grid-area: test1;" type="text" name="testcases[1][args]" placeholder="Command line args (run 1)" size="50">
                    <textarea id="res0" style="grid-area: res1; height: 1.6em;" type="text" name="testcases[1][expected_out]" placeholder="Expected output (run 1)" size="50"></textarea>
                    <input id="test1" style="grid-area: test2;" type="text" name="testcases[2][args]" placeholder="Command line args (run 2)" size="50">
                    <textarea id="res1" style="grid-area: res2; height: 1.6em;" type="text" name="testcases[2][expected_out]" placeholder="Expected output (run 2)" size="50"></textarea>
                    <input id="test2" style="grid-area: test3;" type="text" name="testcases[3][args]" placeholder="Command line args (run 3)" size="50">
                    <textarea id="res2" style="grid-area: res3; height: 1.6em;" type="text" name="testcases[3][expected_out]" placeholder="Expected output (run 3)" size="50"></textarea>
                    <div style="grid-area: spacer; width: 2rem;"></div>
                </div>

                <input type="hidden" id="form-qid" name="qid-selected">
                
                <div class="sub-buttons" style="grid-area: sub-buttons;">
                    <button type="submit" name="submit">Create</button>
                    <button style="display: none;" type="submit" id="form-update-button" name="update">Update</button>
                </div>
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
                $cur_qid = ltrim($question[0], "0"); // js will interpret as octal with zerofill

                $test_cases_query = mysqli_query($con, "SELECT `Arguments`, `Expected output` FROM `courses`.`saved-test-cases` WHERE `Question ID` = $cur_qid;");
                $test_cases = [];
                while($test_case = mysqli_fetch_array($test_cases_query))
                    $test_cases[] = $test_case;

                $sanitized_q = $question;
                foreach ($sanitized_q as $key => $attribute) {
                    $attribute = str_replace('"', '\"', $attribute);
                    $sanitized_q[$key] = str_replace("\n", "", str_replace("\r", '\\n', $attribute));
                }
                $sanitized_tests = $test_cases;
                foreach ($sanitized_tests as $key => $attribute) {
                    $attribute = str_replace('"', '\"', $attribute);
                    $sanitized_tests[$key] = str_replace("\n", "", str_replace("\r", '\\n', $attribute));
                }

                echo <<< EOT
                <div class="qitem" id="qitem_$cur_qid" onclick="populateQuestion_$cur_qid()">
                    <div style="grid-area: qname;" class="qitem-name">$sanitized_q[1]</div>
                    <div style="grid-area: qlang;" class="qitem-lang">$sanitized_q[4]</div>
                    <a onclick="deleteQuestion($cur_qid);" class="qdelbutton" style="grid-area: qdelete;"><span class="material-icons-sharp">delete</span></a>
                </div>
                <script type="text/javascript">
                function populateQuestion_$cur_qid() {
                    var qitems = document.getElementsByClassName("qitem");
                    for (var i = 0; i < qitems.length; i++)
                        qitems[i].classList.remove("active");
                    document.getElementById("form-update-button").style.display = "inline-block";
                    document.getElementById("form-qid").value = "$cur_qid";
                    document.getElementById("qitem_$cur_qid").classList.add("active");
                    document.getElementById("qbank-form").reset();
                    document.getElementById("qname").value = "$sanitized_q[1]";
                    document.getElementById("program-lang").value = "$sanitized_q[4]";
                    document.getElementById("prompt").value = "$sanitized_q[2]";
                    document.getElementById("skeleton").value = "$sanitized_q[3]";
                    
                EOT;
                foreach ($sanitized_tests as $key => $test_case)
                    echo <<< EOT
                    document.getElementById("test$key").value = "$test_case[0]";
                    document.getElementById("res$key").value = "$test_case[1]";
                    EOT;
                echo "} </script>";
            }
        }
        ?>
    </div>
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/common/footer.php"); ?>
</body>
</html>