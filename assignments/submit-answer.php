<?php
session_start();
if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false)
    header("location: /index.php");
$userguid = $_SESSION['guid'];

require_once($_SERVER['DOCUMENT_ROOT'] . "/srv_utils/dbconfig.php");

$data = json_decode(file_get_contents("php://input"), true);
$submitted_answer = $data[2];

// See other answers submitted for this question by this user:
// SELECT * FROM `courses`.`submitted-answers` WHERE `Assignment ID` = $data[0] AND `Question ID` = $data[1] AND `Member GUID` = $_SESSION['guid'];

$possible_points = mysqli_fetch_array(mysqli_query($con, "SELECT `Points` FROM `courses`.`question-sets` WHERE `Assignment ID` = $data[0] AND `Question ID` = $data[1];"));
$piston_query = mysqli_fetch_array(mysqli_query($con, "SELECT languages.`Piston name`, languages.`Piston version`, languages.`File extension` from `courses`.`languages-avail` as languages INNER JOIN `courses`.`saved-questions` as questions WHERE questions.`Question ID` = $data[1] AND questions.`Code Language` = languages.`Human-readable`;"));

$test_cases_query = mysqli_query($con, "SELECT `Arguments`, `Expected output` FROM `courses`.`saved-test-cases` WHERE `Question ID` = $data[1];");
$test_cases = [];
while($test_case = mysqli_fetch_array($test_cases_query))
    $test_cases[] = $test_case;

$piston_lang = strval($piston_query[0]);
$piston_version = strval($piston_query[1]);
$piston_ext = strval($piston_query[2]);
$total_points = 0;

$sandbox_host = "https://emkc.org/api/v2/piston/execute";

$headers = array(
    "Accept: application/json",
    "Content-Type: application/json"
);

foreach ($test_cases as $test_case) {
    sleep(1); // TODO Self hosting Piston will allow for removal of this delay. Public API limit of 5 reqs/second. Faster than 1 second sees issues.
    $user_answer = <<< ANSWER
{
    "language": "$piston_lang",
    "version": "$piston_version",
    "files": [
        {
            "name": "answer$piston_ext",
            "content": $data[2]
        }
    ],
    "args": $test_case[0]
}
ANSWER;

    $curl = curl_init($sandbox_host);
    curl_setopt($curl, CURLOPT_URL, $sandbox_host);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $user_answer);

    $resp = curl_exec($curl);
    curl_close($curl);

    $decoded_resp = json_decode($resp, true);
    $decoded_resp['run']['output'] = substr($decoded_resp['run']['output'], 0, -1); //removes trailing newline added by Piston

    similar_text($test_case[1], $decoded_resp['run']['output'], $accuracy);
    $total_points += $accuracy;
}
$calculated_points = number_format($possible_points[0] * $total_points / 100 / count($test_cases), 2, '.', '');

$submission_requirements = mysqli_fetch_array(mysqli_query($con, "SELECT `Date opened`, `Date closed`, `Allow resubmit` FROM `courses`.`assignments` WHERE `Assignment ID` = $data[0];"));
$already_submitted_ct = mysqli_num_rows(mysqli_query($con, "SELECT * FROM `courses`.`submitted-answers` WHERE `Assignment ID` = $data[0] AND `Question ID` = $data[1] AND `Member GUID` = $userguid;"));
if(!$already_submitted_ct || $submission_requirements[2]){
    mysqli_query($con, "DELETE FROM `courses`.`submitted-answers` WHERE `Assignment ID` = $data[0] AND `Question ID` = $data[1] AND `Member GUID` = $userguid;");
    mysqli_query($con, "INSERT INTO `courses`.`submitted-answers` (`Assignment ID`, `Question ID`, `Member GUID`, `Answer`, `Score`) VALUES ($data[0], $data[1], $userguid, $submitted_answer, $calculated_points);");
} else {
    error_log("User $userguid tried to resubmit an answer without having permission.", 0);
}