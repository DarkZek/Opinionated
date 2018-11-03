<?php

session_start();

//Make sure xrsf token matches
require("../../include/permissions/check_xsrf.php");

//Only allow New Zealanders to vote
require("../../include/geo/nz_only.php");

//Make sure user is logged in
require("../../include/permissions/user_only.php");

//Make sure user is logged in
require("../../include/sql/sql.php");

function Error($error) {
  echo($error);
  die();
}

//Get post name
if (!isset($_POST["id"])) {
  Error("[ERROR] No id provided");
}

$id = $_POST["id"];

//
//Make sure user hasnt already skipped the post
//
$user_skipped_query = "SELECT * FROM poll_skips WHERE user_id = ? AND poll_id = ?;";
$user_skipped_statement = $conn->prepare($user_skipped_query);
$result = $user_skipped_statement->execute([$_SESSION["id"], $id]);

if (count($user_skipped_statement->fetchAll()) > 0) {
  Error("Success");
}

//
//Check if a post exists with that name
//
$name_query = "SELECT * FROM polls WHERE id = ?;";
$name_statement = $conn->prepare($name_query);
$name_statement->execute([$id]);
$poll = $name_statement->fetchAll();

if (count($poll) == 0) {
  Error("[ERROR] There is no poll with that name");
}

//Get the time
$date = new DateTime();



//
//Build SQL Query
//
$sql = "UPDATE polls SET upvotes = ? WHERE id = ?";
$statement = $conn->prepare($sql);
$result = $statement->execute([$poll[0]->upvotes + 1, $id]);
if ($result === False) {
    Error("There was an error submitting your poll");
}




//
//Update the users skipped posts
//
$user_query = "INSERT INTO poll_skips (id, poll_id, user_id) VALUES (NULL, ?, ?);";
$user_statement = $conn->prepare($user_query);
$result = $user_statement->execute([$id, $_SESSION["id"]]);

echo("Success");
