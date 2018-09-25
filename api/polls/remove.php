<?php

//Run
include("/var/www/html/include/run/Runner.php");

//Only allow New Zealanders to use
require("/var/www/html/include/geo/nz_only.php");

//Make sure only admins can access it
require("/var/www/html/include/permissions/admin_only.php");

require("/var/www/html/include/permissions/check_xsrf.php");

require("/var/www/html/include/sql/sql.php");

if (!isset($_POST["id"])) {
  die("[ERROR] No input post id");
}

if (!isset($_POST["reason"])) {
  die("[ERROR] No input reason");
}

$poll_id = $_POST["id"];
$reason = $_POST["reason"];

//Create sql query
$reports_query = "DELETE FROM poll_reports WHERE poll_id = ?;";
$reports_statement = $conn->prepare($reports_query);
$reports_statement->execute([$poll_id]);


$upvotes_query = "DELETE FROM poll_upvotes WHERE poll_id = ?;";
$upvotes_statement = $conn->prepare($upvotes_query);
$upvotes_statement->execute([$poll_id]);


$upvotes_query = "DELETE FROM polls WHERE id = ?;";
$upvotes_statement = $conn->prepare($upvotes_query);
$upvotes_statement->execute([$poll_id]);

die("Success");
