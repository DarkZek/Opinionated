<?php

session_start();

//Run
include("../../../include/run/Runner.php");

//Make sure xrsf token matches
require("../../../include/permissions/check_xsrf.php");

//Make sure user is logged in
require("../../../include/permissions/user_only.php");

//Get post content
if (!isset($_POST["content"])) {
  die("No content provided");
}

//Get post id
if (!isset($_POST["poll_id"])) {
  die("[ERROR] No post id provided");
}

$content = $_POST["content"];
$poll_id = $_POST["poll_id"];

if (strlen($content) < 50 || strlen($content) > 500) {
  die("Your post must be 50-500 characters long");
}

#Load MySQL connection
require("../../../include/sql/sql.php");

//Get the time
$date = new DateTime();

//Build SQL Query
$sql = "INSERT INTO poll_perspectives (content, user_id, poll_id, upvotes) VALUES (?, ?, ?, 0);";
$statement = $conn->prepare($sql);
$result = $statement->execute([$content, $_SESSION["id"], $poll_id]);

if ($result === True) {
  echo("Success");
} else {
  echo("There was an error submitting your poll perspective");
}
