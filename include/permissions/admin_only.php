<?php
if (!isset($_SESSION["display_name"])) {
  session_start();
}

if ($_SESSION["rank"] < 1) {
  header("Location: /");
  die();
}
