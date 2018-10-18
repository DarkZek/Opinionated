<?php namespace Opinionated;

session_start();

//Make sure xrsf token matches
require("../../include/permissions/check_xsrf.php");

//Make sure user is logged in
require("../../include/permissions/user_only.php");

//Only allow New Zealanders to vote
require("../../include/geo/nz_only.php");

//Connect to MSQL database
require("../../include/sql/sql.php");

function Error($error) {
  echo($error);
  die();
}




//
//Make sure user has already voted on the post
//

//Send SQL Query
$user_upvoted_query = "SELECT user_id FROM (SELECT user_id FROM main_poll_upvotes UNION SELECT user_id FROM main_poll_downvotes) AS user_id WHERE user_id = ?;";
$user_upvoted_statement = $conn->prepare($user_upvoted_query);
$result = $user_upvoted_statement->execute([$_SESSION["id"]]);

//If we get no results they have not voted
if (count($user_upvoted_statement->fetchAll()) == 0) {
  //Error("[ERROR] You have not voted on that post!");
}





//
// Remove vote by user
//
$sql = "DELETE FROM main_poll_upvotes WHERE user_id = ?;";
$statement = $conn->prepare($sql);
$result = $statement->execute([$_SESSION["id"]]);

if ($statement->rowCount() > 0) {
  //Success! It was an upvote
  $vote = -1;
} else {
  $vote = 1;

  //Remove downvotes
  $sql = "DELETE FROM main_poll_downvotes WHERE user_id = ?;";
  $statement = $conn->prepare($sql);
  $result = $statement->execute([$_SESSION["id"]]);
}



//
// Update the main poll upvote count
//
$sql = "UPDATE main_polls SET upvotes = upvotes + ? ORDER BY id DESC limit 1;";
$statement = $conn->prepare($sql)->execute([$vote]);


echo("Success");
