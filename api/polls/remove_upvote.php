<?php

session_start();


//Only allow New Zealanders to vote
require("/var/www/html/include/geo/nz_only.php");

//Run
include("/var/www/html/include/run/Runner.php");

//Make sure xrsf token matches
require("/var/www/html/include/permissions/check_xsrf.php");

//Make sure user is logged in
require("/var/www/html/include/permissions/user_only.php");

//Make sure user is logged in
require("/var/www/html/include/sql/sql.php");

function Error($error) {
  echo($error);
  die();
}

//Get post name
if (!isset($_POST["id"])) {
  Error("[ERROR] No id provided");
}

$id = $_POST["id"];

//Make sure user has already upvoted the post
$user_upvoted_query = "SELECT * FROM poll_upvotes WHERE user_id = ? AND poll_id = ?;";

$user_upvoted_statement = $conn->prepare($user_upvoted_query);

$result = $user_upvoted_statement->execute([$_SESSION["id"], $id]);

if (count($user_upvoted_statement->fetchAll()) === 0) {
  Error("[ERROR] You havent upvoted that post!");
}

//Check if a post exists with that name
$name_query = "SELECT * FROM polls WHERE id = ?;";

$name_statement = $conn->prepare($name_query);

$name_statement->execute([$id]);

$poll = $name_statement->fetchAll();
if (count($poll) == 0) {
  Error("[ERROR] There is no poll with that name");
}

//Get the time
$date = new DateTime();

//Build SQL Query
$sql = "UPDATE polls SET upvotes = ? WHERE id = ?";

$statement = $conn->prepare($sql);

$result = $statement->execute([$poll[0]->upvotes - 1, $id]);

if ($result === False) {
    Error("There was an error submitting your poll");
}

//Update the users upvoted posts
$user_query = "DELETE FROM poll_upvotes where poll_id = ? AND user_id = ?;";

$user_statement = $conn->prepare($user_query);

$result = $user_statement->execute([$id, $_SESSION["id"]]);

echo("Success");
