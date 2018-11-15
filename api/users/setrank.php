<?php
//Make sure only admins can access it
require("../../include/permissions/admin_only.php");
require("../../include/permissions/check_xsrf.php");
require("../../include/sql/sql.php");

if (!isset($_POST["id"])) {
  die("[ERROR] No input id");
}

if (!isset($_POST["rank"])) {
  die("[ERROR] No input rank");
}

$id = $_POST["id"];
$rank = $_POST["rank"];

//Create sql query
$query = "UPDATE users SET rank = ? WHERE id = ?;";

$statement = $conn->prepare($query);
$result = $statement->execute([$rank, $id]);

if ($statement->rowCount() !== 1) {
  die("There was no user with that username or they already have that rank");
}

if ($result !== True) {
  die("[ERROR] Could not complete the action");
}
die("Success");
