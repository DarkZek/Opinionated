<?php
//Make sure only admins can access it
require("../../../include/admin_only.php");
require("../../../include/check_xsrf.php");
require("../../../include/sql/sql.php");

if (!isset($_POST["id"])) {
  die("[ERROR] No input id");
}

$reports_id = $_POST["id"];


//
// Update database
//
$query = "DELETE FROM poll_reports WHERE id = ?";
$statement = $conn->prepare($query);
$result = $statement->execute([$reports_id]);


if ($result !== True) {
  die("[ERROR] Could not complete the action");
}

echo("Success");
