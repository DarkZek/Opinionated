<?php
//Make sure only admins can access it
require("/var/www/html/include/permissions/admin_only.php");

require("/var/www/html/include/permissions/check_xsrf.php");

require("/var/www/html/include/sql/sql.php");

if (!isset($_POST["username"])) {
  die("[ERROR] No input id");
}

if (!isset($_POST["rank"])) {
  die("[ERROR] No input id");
}

$username = $_POST["username"];
$rank = $_POST["rank"];

//Create sql query
$query = "UPDATE users SET rank = ? WHERE username=?;";

$statement = $conn->prepare($query);
$result = $statement->execute([$rank, $username]);

if ($statement->rowCount() !== 1) {
  die("[ERROR] Either there was no user with that username or they already have admin");
}

if ($result === True) {
  die("Success");
} else {
  die("[ERROR] Could not complete the action");
}
