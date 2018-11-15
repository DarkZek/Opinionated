<?php namespace Opinionated;
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
// Get user info
//
$query = "SELECT * FROM users WHERE id = ?;";
$u_statement = $conn->prepare($query);
$result = $u_statement->execute([$user_id]);
$user_info = $u_statement->fetch();

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

$email = $u_statement->fetchAll()[0]->email;

//
// Add it to list of mail to be sent
//
$query = "INSERT INTO send_emails (content, sender, receiver, title) VALUES (?, ?, ?, ?);";
$statement = $conn->prepare($query);
$statement->execute([$mail, 0, $email, "Your Opinionated account has been terminated"]);

echo("Success");
