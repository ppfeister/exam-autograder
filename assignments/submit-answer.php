<?php
session_start();
if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false)
    header("location: /index.php");

require_once($_SERVER['DOCUMENT_ROOT'] . "/srv_utils/dbconfig.php");

$data = json_decode(file_get_contents("php://input"), true);

$expected_result = mysqli_fetch_array(mysqli_query($con, "SELECT `Question Tests`, `Question Validation` FROM `courses`.`saved-questions` WHERE `Question ID` = $data[1];"));
$piston_query = mysqli_fetch_array(mysqli_query($con, "SELECT languages.`Piston name`, languages.`Piston version`, languages.`File extension` from `courses`.`languages-avail` as languages INNER JOIN `courses`.`saved-questions` as questions WHERE questions.`Question ID` = $data[1] AND questions.`Code Language` = languages.`Human-readable`;"));
$piston_lang = strval($piston_query[0]);
$piston_version = strval($piston_query[1]);
$piston_ext = strval($piston_query[2]);

$sandbox_host = "https://emkc.org/api/v2/piston/execute";

$headers = array(
    "Accept: application/json",
    "Content-Type: application/json"
);

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
    "args": "$expected_result[0]"
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
similar_text($expected_result[1], $decoded_resp['run']['output'], $accuracy_score);

error_log($decoded_resp['run']['stdout'], 0);
error_log($accuracy_score, 0);