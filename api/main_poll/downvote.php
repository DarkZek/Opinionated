<?php

session_start();

//Make sure xrsf token matches
require("/var/www/html/include/permissions/check_xsrf.php");

//Make sure user is logged in
require("/var/www/html/include/permissions/user_only.php");

//Only allow New Zealanders to vote
require("/var/www/html/include/geo/nz_only.php");

//Connect to MSQL database
require("/var/www/html/include/sql/sql.php");

//Easily throw errors
function Error($error) {
  echo($error);
  die();
}


//
// Make sure user hasnt already upvoted the post
//
$user_upvoted_query = "SELECT user_id FROM (SELECT user_id FROM main_poll_upvotes UNION SELECT user_id FROM main_poll_downvotes) AS user_id WHERE user_id = ?;";
$user_upvoted_statement = $conn->prepare($user_upvoted_query);
$result = $user_upvoted_statement->execute([$_SESSION["id"]]);

//Make sure they have not already voted
if (count($user_upvoted_statement->fetchAll()) > 0) {
  Error("[ERROR] Already upvoted/downvoted that post!");
}



//
// Set new poll upvotes count
//
$sql = "UPDATE main_polls SET upvotes = upvotes-1 ORDER BY id DESC limit 1;";
$statement = $conn->prepare($sql)->execute();



//
//Update the users upvoted polls
//
$user_query = "INSERT INTO main_poll_downvotes (user_id) VALUES (?);";
$conn->prepare($user_query)->execute([$_SESSION["id"]]);

echo("Success");
