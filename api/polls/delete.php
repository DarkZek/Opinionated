<?php
//Make sure only admins can access it
require("/var/www/html/include/permissions/admin_only.php");

//Only allow New Zealanders to vote
require("/var/www/html/include/geo/nz_only.php");

require("/var/www/html/include/permissions/check_xsrf.php");

if (!isset($_POST["id"])) {
  die("[ERROR] No input post id");
}

if (!isset($_POST["reason"])) {
  die("[ERROR] No input reason");
}

$post_id = $_POST["id"];
$reason = $_POST["reason"];

//Create sql query
$query = "DELETE FROM polls WHERE id = ?;";

$statement = $conn->prepare($query);
$result = $statement->execute([$post_id]);

if ($result === True) {
  die("Success");
} else {
  die("[ERROR] Could not complete the action");
}
