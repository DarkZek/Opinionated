<?php
//Start the session
session_start();

include("/var/www/html/include/run/Runner.php");
require("/var/www/html/include/permissions/check_xsrf.php");
require("/var/www/html/include/permissions/user_only.php");
require("/var/www/html/include/sql/sql.php");

if (!isset($_POST["email"])) {
  die("[ERROR] No email preference set");
}

if ($_POST["email"] === "true") {
  $email = True;
} else {
  $email = False;
}

//
//Set email preferences
//
if ($email === True) {
  $q = "UPDATE users SET subscribed_emails = 1 WHERE id = ?;";
  $stmnt = $conn->prepare($q);
  $stmnt->execute([$_SESSION["id"]]);
}


//
// Set shown into
//
$q = "UPDATE users SET seen_post_register = 1 WHERE id = ?";
$stmnt = $conn->prepare($q);
$stmnt->execute([$_SESSION["id"]]);

$_SESSION["seen_post_register"] = "1";

die("Success");
