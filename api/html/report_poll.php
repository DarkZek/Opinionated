<?php namespace Opinionated;
session_start();
if (!isset($_SESSION["xsrf_token"])) {
  require("./login_page.php");
  die();
}
$title = "REPORT POLL";
$content = "../../include/html/dialogues/report_poll.php";
<<<<<<< HEAD
$settings->style = "width: 35%;";
=======
>>>>>>> master
require("../../include/html/dialogue.php");
?>
