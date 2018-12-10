<?php namespace Opinionated;
session_start();
if (!isset($_SESSION["xsrf_token"])) {
  require("./login_page.php");
  die();
}
$title = "REPORT PERSPECTIVE";
$content = "../../include/html/dialogues/report_perspective.php";
$settings->style = "width: 35%;";
require("../../include/html/dialogue.php");
?>
