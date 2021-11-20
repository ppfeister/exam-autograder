<?php
session_start();
if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false)
    header("location: /index.php");
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
<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/common/header-internal.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/common/sidebar-left.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/srv_utils/dbconfig.php");
?>

<div id="content-wrapper">
    <div class="section-main">
        <h2>CS 490 - Hello World</h2>
        <div class="subsection-level1">
            <p class="assignment-desc">Using Python, print "Hello World" to the console.</p>
            <div id="editor" style="min-height: 15em;">function foo(items) {
                var x = "All this is syntax highlighted";
                return x;
                }</div>
        </div>
    </div>
    <?php require_once('../common/footer.php'); ?>
</div>

<!----- EDITOR ----->
<script src="/scripts/ace/ace.js" type="text/javascript" charset="utf-8"></script>
<script>
    var editor = ace.edit("editor");
    editor.setTheme("ace/theme/eclipse");
    editor.session.setMode("ace/mode/python");
</script>
<!----- EDITOR ----->

</body>
</html>
