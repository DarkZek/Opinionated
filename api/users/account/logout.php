<?php
//Start the session
session_start();

require("/var/www/html/include/permissions/check_xsrf.php");
require("/var/www/html/include/permissions/user_only.php");

//Destroy it
if (session_destroy() === True) {
  header("Location: /");
} else {
  die("[ERROR] Could not logout");
}
