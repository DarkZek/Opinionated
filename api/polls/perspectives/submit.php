<?php

session_start();

//Run
include("/var/www/html/include/run/Runner.php");

//Make sure xrsf token matches
require("/var/www/html/include/permissions/check_xsrf.php");

//Make sure user is logged in
require("/var/www/html/include/permissions/user_only.php");

function Error($error) {
  $_SESSION["error"] = $error;
  header("Location: /vote");
  die();
}

//Get post content
if (!isset($_POST["content"])) {
  Error("[ERROR] No content provided");
}

//Get post id
if (!isset($_POST["poll_id"])) {
  Error("[ERROR] No post id provided");
}

$content = $_POST["content"];
$poll_id = $_POST["poll_id"];

if (strlen($content) < 50 || strlen($content) > 500) {
  Error("[Error] Your post must be 50-500 characters long");
}

#Load MySQL connection
require("/var/www/html/include/sql/sql.php");

//Get the time
$date = new DateTime();

//Build SQL Query
$sql = "INSERT INTO poll_perspectives (content, created, user_id, poll_id, upvotes) VALUES (?, ?, ?, ?, 0);";

$statement = $conn->prepare($sql);

$result = $statement->execute([$content, $date->getTimestamp(), $_SESSION["id"], $poll_id]);

if ($result === True) {
  $_SESSION["info"] = "Successfully submitted poll perspective";
  setcookie("poll_id", "", time()-3600);
  header("Location: /vote");
} else {
  echo("There was an error submitting your poll perspective");
}
