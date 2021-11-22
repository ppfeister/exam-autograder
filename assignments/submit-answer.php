<?php
session_start();
$data = json_decode(file_get_contents("php://input"), true);
error_log("ses: " . $_SESSION['guid'], 0);
error_log("aid: " . $data[0], 0);
error_log("qid: " . $data[1], 0);
error_log("ans: " . $data[2], 0);