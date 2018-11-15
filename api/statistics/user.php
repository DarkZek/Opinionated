<?php
//This file is named badly so the request does not get blocked by ad blockers

//Make sure only admins can access it
require("../../include/sql/sql.php");

$data = sha1($_SERVER["HTTP_USER_AGENT"] . $_SERVER["REMOTE_ADDR"]);

//Create sql query
$query = "SELECT * FROM analytics_today WHERE unique_id = ?;";
$statement = $conn->prepare($query);
$result = $statement->execute([$data]);

if ($statement->rowCount() !== 0) {
  //Not really success, but incase somebody is trying to mess us the statistics we dont want them to know
  die("Success");
}

//
// Insert new row
//
$query = "INSERT INTO analytics_today (unique_id) VALUES (?);";
$statement = $conn->prepare($query);
$result = $statement->execute([$data]);

die("Success");
