<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Coding examination website with automatic grading of student-submitted code">
    <title>bitlab - Student Coding Lab</title>
    <link rel="stylesheet" href="../styles/master.css" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
</head>
<body>
<?php
require_once('../common/header-internal.php');
?>
    <!--<div class="section-menu"></div>-->
    <div class="section-main">
        <div class="course-selection-block first-item">
            <div class="course-info">
                <span class="course-name">CS 490</span>
            </div>
            <div class="course-assignment-list">
                <div class="assignment-listing">
                    <span class="assignment-name">Milestone 1</span>
                    <span class="assignment-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit</span>
                    <span class="assignment-duedate">Oct 20, 2021 11:59pm<span class="material-icons-sharp status-icon">task</span></span>
                </div>
                <div class="assignment-listing">
                    <span class="assignment-name">Milestone 1</span>
                    <span class="assignment-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit</span>
                    <span class="assignment-duedate status-icon">Oct 20, 2021 11:59pm<span class="material-icons-sharp status-icon">task</span></span>
                </div>
                <div class="assignment-listing">
                    <span class="assignment-name">Milestone 1</span>
                    <span class="assignment-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit</span>
                    <span class="assignment-duedate">Oct 20, 2021 11:59pm<span class="material-icons-sharp status-icon">hourglass_bottom</span></span>
                </div>
            </div>
        </div>
        <div class="course-selection-block">
            <div class="course-info">
                <span class="course-name">CS 490</span>
            </div>
            <div class="course-assignment-list">
                assignments go here
            </div>
        </div>
        <div class="course-selection-block last-item">
            <div class="course-info">
                <span class="course-name">CS 490</span>
            </div>
            <div class="course-assignment-list">
                assignments go here
            </div>
        </div>
    </div>
</body>
</html>
