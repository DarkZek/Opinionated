<?php
include("/var/www/html/include/run/Runner.php");
include("/var/www/html/include/sql/sql.php");
session_start();

if (!isset($_GET["key"])) {
  $_SESSION["error"] = "[ERROR] No key provided";
  header("Location: /login");
  die();
}
if (!isset($_GET["u"])) {
  $_SESSION["error"] = "[ERROR] No user id provided";
  header("Location: /login");
  die();
}

function Error($error) {
  echo($error);
  die();
}

$key = $_GET["key"];
$user_id = $_GET["u"];

//
// Check if key matches
//
$q = "DELETE FROM verify_user_keys WHERE user_id = ? AND verification_key = ?";
$statement = $conn->prepare($q);
$statement->execute([$user_id, $key]);

if ($statement->rowCount() === 0) {
  header("Location: /");
}

//
// Set verified
//
$q = "UPDATE users SET verified = 1 WHERE id = ?";
$statement = $conn->prepare($q);
$statement->execute([$user_id]);


//
// Redirect
//
header("Location: /");
