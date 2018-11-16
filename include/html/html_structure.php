<?php namespace Opinionated;
echo("<html>");

if (isset($_POST["dynamic"])) {
  //Its dynamically loading the page, no need for header
  echo("<body>");
  return;
}
require(__DIR__ . "/head.php");
?>
