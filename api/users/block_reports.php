<?php
//Make sure only admins can access it
require("/var/www/html/include/permissions/admin_only.php");
require("/var/www/html/include/permissions/check_xsrf.php");
require("/var/www/html/include/sql/sql.php");

if (!isset($_POST["id"])) {
  die("[ERROR] No input id");
}

$user_id = $_POST["id"];


//
// Update database
//
$query = "UPDATE users SET reports_blocked = 1 WHERE id = ?;";
$statement = $conn->prepare($query);
$result = $statement->execute([$user_id]);

if ($result !== True) {
  die("[ERROR] Could not complete the action");
}


//
// Remove all other reports by user
//
$query = "DELETE FROM poll_reports WHERE user_id = ?;";
$statement = $conn->prepare($query);
$result = $statement->execute([$user_id]);

if ($result !== True) {
  die("[ERROR] Could not complete the action");
}

echo("Success");
