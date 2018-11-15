<?php
require("./vendor/autoload.php");

$TITLE = "Opinionated | Login";

//Include html bits
require("./include/html/html_structure.php");

$title = "LOGIN";
$content = "./include/html/dialogues/login_page.php";
$settings->force = True;
require("./include/html/dialogue.php");
