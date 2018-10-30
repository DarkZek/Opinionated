<<<<<<< HEAD
<?php
require("./vendor/autoload.php");

$TITLE = "Opinionated | Login";
<<<<<<< HEAD

//Include html bits
require("./include/html/html_structure.php");
=======

//Include html bits
require("./include/html/html_structure.php");
=======
<?php namespace Opinionated;
$TITLE = "Opinionated | Register";
$HEAD = "<script src='https://www.google.com/recaptcha/api.js'></script>";

//Include html data
require("./include/html/html_structure.php");
//New zealanders only
require("./include/geo/nz_only.php");
//Load register page
require("./include/html/register_page.php");
>>>>>>> master
>>>>>>> master

$title = "LOGIN";
$content = "./include/html/dialogues/login_page.php";
$settings->force = True;
require("./include/html/dialogue.php");
