<?php
session_start();
if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false)
    header("location: /index.php");

require_once($_SERVER['DOCUMENT_ROOT'] . "/srv_utils/dbconfig.php");

$data = json_decode(file_get_contents("php://input"), true);

$piston_query = mysqli_fetch_array(mysqli_query($con, "SELECT languages.`Piston name`, languages.`Piston version`, languages.`File extension` from `courses`.`languages-avail` as languages INNER JOIN `courses`.`saved-questions` as questions WHERE questions.`Question ID` = 1 AND questions.`Code Language` = languages.`Human-readable`;"));
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
    ]
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

error_log("piston result: " . $resp);