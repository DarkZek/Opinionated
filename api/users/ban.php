<?php
//Make sure only admins can access it
require("../../include/permissions/admin_only.php");
require("../../include/permissions/check_xsrf.php");
require("../../include/sql/sql.php");
require("../../include/html/mail.php");

if (!isset($_POST["id"])) {
  die("[ERROR] No input id");
}

$user_id = $_POST["id"];

//
// Update database
//
$query = "UPDATE users SET banned = 1 WHERE id = ?;";
$statement = $conn->prepare($query);
$result = $statement->execute([$user_id]);

if ($result !== True) {
  die("[ERROR] Could not complete the action");
}

$mail = createEmail($_POST["reason"]);

echo("Success" . $mail);
