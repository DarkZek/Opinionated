<?php
//Start the session
session_start();

require("/var/www/html/include/permissions/check_xsrf.php");
require("/var/www/html/include/permissions/user_only.php");
require("/var/www/html/include/sql/sql.php");

//
// Verify password if its not a google account
//
if ($_SESSION["account_type"] !== "google") {
  if (!isset($_POST["password"])) {
    die("[ERROR] Invalid Passwor");
  }

  $password = $_POST["password"];

  //
  // Get current password
  //
  $query = "SELECT password FROM users WHERE id = ?";
  $statement = $conn->prepare($query);
  $result = $statement->execute([$_SESSION["id"]]);

  echo($statement->fetch()->password . "     " . $password);

  //Check if password matches
  $checked = password_verify($password, $statement->fetch()->password);

  if ($checked === False) {
    die("[ERROR] Invalid Password");
  }
}


//
// Delete data from database
//
$query = "DELETE FROM users WHERE id = ?";
$statement = $conn->prepare($query);
$statement->execute([$_SESSION["id"]]);


//Delete session
session_destroy();


session_start();
$_SESSION["error"] = "Deleted Account";

die("Success");
