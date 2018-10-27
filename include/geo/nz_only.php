<?php namespace Opinionated;

require("/var/www/html/include/geo/check_if_nz.php");

if (!$from_nz) {
  $_SESSION["error"] = "You have to be from New Zealand to do that!";
  Header("Location: /");
  die();
}
