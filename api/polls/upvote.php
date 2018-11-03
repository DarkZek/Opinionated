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
//Make sure user hasnt already upvoted the post
//
$user_upvoted_query = "SELECT * FROM poll_upvotes WHERE user_id = ? AND poll_id = ?;";
$user_upvoted_statement = $conn->prepare($user_upvoted_query);
$result = $user_upvoted_statement->execute([$_SESSION["id"], $id]);

if (count($user_upvoted_statement->fetchAll()) > 0) {
  die("Success");
}


//
// Update poll upvotes
//
$sql = "UPDATE polls SET upvotes = upvotes+1 WHERE id = ?";
$statement = $conn->prepare($sql);
$result = $statement->execute([$id]);

if ($result === False || $statement->rowCount() === 0) {
    Error("[ERROR] There is no poll with that name");
}



//
//Update the users upvoted posts
//
$user_query = "INSERT INTO poll_upvotes (id, poll_id, user_id) VALUES (NULL, ?, ?);";
$user_statement = $conn->prepare($user_query);
$result = $user_statement->execute([$id, $_SESSION["id"]]);


echo("Success");
