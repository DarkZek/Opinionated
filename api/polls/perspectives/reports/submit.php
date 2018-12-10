<?php

session_start();

//Run
include("../../../../include/run/Runner.php");

//Only allow New Zealanders
require("../../../../include/geo/nz_only.php");

//Make sure xrsf token matches
require("../../../../include/permissions/check_xsrf.php");

//Make sure user is logged in
require("../../../../include/permissions/user_only.php");

//Make sure user is logged in
require("../../../../include/sql/sql.php");

function Error($error) {
  echo($error);
  die();
}


//
// Get post data
//

//Get post name
if (!isset($_POST["id"])) {
  Error("[ERROR] No id provided");
}
if (!isset($_POST["reason"])) {
  Error("[ERROR] No reason provided");
}

$id = $_POST["id"];
$reason = $_POST["reason"];


//
// Make sure user is not blocked from reporting
//

$qu_blocked = "SELECT * FROM perspective_reports WHERE user_id = ? AND perspective_id = ?;";
$s_blocked = $conn->prepare($qu_blocked);
$s_blocked->execute([$_SESSION["id"], $id]);

if (count($s_blocked->fetchAll()) > 0) {
  //Fake return so they dont know
  die("Success");
}


//
//Make sure user hasnt already reported the post
//

$user_reported_query = "SELECT * FROM perspective_reports WHERE user_id = ? AND perspective_id = ?;";
$user_reported_statement = $conn->prepare($user_reported_query);
$result = $user_reported_statement->execute([$_SESSION["id"], $id]);

if (count($user_reported_statement->fetchAll()) > 0) {
  Error("[ERROR] Already reported that post!");
}




//
//Check if a post exists with that name
//
$name_query = "SELECT * FROM poll_perspectives WHERE id = ?;";
$name_statement = $conn->prepare($name_query);
$name_statement->execute([$id]);
$poll = $name_statement->fetchAll();

if (count($poll) == 0) {
  Error("[ERROR] There is no perspective with that id");
}



//
//Get the time
//
$date = new DateTime();

//Build SQL Query
$sql = "INSERT INTO perspective_reports (perspective_id, user_id, reason) VALUES (?, ?, ?);";
$statement = $conn->prepare($sql);
$result = $statement->execute([$id, $_SESSION["id"], $reason]);

if ($result === False) {
    Error("There was an error submitting your report");
}

echo("Success");
