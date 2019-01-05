<?php
//Start the session
session_start();

require("../../include/permissions/check_xsrf.php");
require("../../include/permissions/user_only.php");
require("../../include/sql/sql.php");

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


//
// Notify user they've been pwned
//
if ($_SESSION["account_type"] === "account") {
  $context = stream_context_create([
      'http'  =>  [
          'user_agent'    =>  'OpinionatedSecurityService'
      ]
  ]);
  $data = file_get_contents("https://haveibeenpwned.com/api/v2/breachedaccount/" . $_SESSION["email"], false, $context);

  if ($data != "") {
    die("PwnedAccountSuccess");
  }
}
die("Success");
