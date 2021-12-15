<?php
session_start();
if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false)
    header("location: /index.php");
$userguid = $_SESSION['guid'];

require_once($_SERVER['DOCUMENT_ROOT'] . "/srv_utils/dbconfig.php");

$qid = json_decode(file_get_contents("php://input"), true)[0];
mysqli_query($con, "UPDATE `courses`.`saved-questions` SET `Banked` = 0 WHERE `Question ID` = $qid AND `Question Owner` = $userguid;") or die(mysqli_error($con));