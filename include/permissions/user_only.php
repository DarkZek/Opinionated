<?php
if (!isset($_SESSION["display_name"])) {
  session_start();
}

//Check if they're logged in
if (!isset($_SESSION["display_name"])) {
  header("Location: /");
  die();
}
