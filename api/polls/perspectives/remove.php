<?php

//Run
require("../../../include/run/Runner.php");

//Only allow New Zealanders to use
require("../../../include/geo/nz_only.php");

//Make sure only admins can access it
require("../../../include/permissions/admin_only.php");
require("../../../include/permissions/check_xsrf.php");
require("../../../include/sql/sql.php");

if (!isset($_POST["id"])) {
  die("[ERROR] No input post id");
}

if (!isset($_POST["reason"])) {
  die("[ERROR] No input reason");
}

$perspective_id = $_POST["id"];
$reason = $_POST["reason"];

$perspectives_query = "SELECT * FROM poll_perspectives WHERE id = ?; DELETE FROM poll_perspectives WHERE id = ?;";
$perspectives_statement = $conn->prepare($perspectives_query);
$perspectives_statement->execute([$perspective_id, $perspective_id]);

$user_query = "DELETE FROM users WHERE id = ?;";
$user_statement = $conn->prepare($user_query);
$user_statement->execute([$_POST["id"]]);

$recipient = $perspectives_statement->email;
$title = "Your perspective has been removed.";


//
// Create email to parse
//
$content[0] = new \stdClass();
$content[0]->content = "<h1 style='color: white;'>Your Perspective Has Been Removed</h1>";
$content[0]->type = "div";
$content[0]->style="width: 100%; background-color: #57BF37;";

$content[1] = new \stdClass();
$content[1]->content = $reason;

$email_contents = createEmail($content);

//
// Add to mail queue
//
$email_query = "INSERT INTO send_emails (content, receiver, title, sender) VALUES (?, ?, ?, ?);";
$statement = $conn->prepare($email_query);
$statement->execute([$email_contents, $email, $title, 0]);

die("Success");
