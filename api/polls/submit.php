<?php

session_start();

//Run
include("../../include/run/Runner.php");

//Only allow New Zealanders to vote
require("../../include/geo/nz_only.php");

//Make sure xrsf token matches
require("../../include/permissions/check_xsrf.php");

//Make sure user is logged in
require("../../include/permissions/user_only.php");

#Logger
require("../../include/permissions/Logger.php");

function Error($error) {
  $_SESSION["error"] = $error;
  header("Location: /user/polls/submit");
  die();
}

//
// Verify inputs
//

//Get post name
if (!isset($_POST["name"])) {
  Error("[ERROR] No name provided");
}
//Get post description
if (!isset($_POST["desc"])) {
  Error("[ERROR] No description provided");
}

$name = $_POST["name"];
$desc = $_POST["desc"];

if (strlen($name) < 10 || strlen($name) > 150) {
  Error("[Error] Your post must be 10-150 characters long");
}

$filter = "/^[a-zA-Z0-9\ ,!.'_\-\(\)]*$/";

#Load MySQL connection
require("../../include/sql/sql.php");

if (preg_match($filter, $name) !== 1) {
  Error("[ERROR] Invalid characters used. Please use only numbers, letters, spaces and ._',-()!");
}



//
//Check if a post exists with that name
//
$name_query = "SELECT * FROM polls WHERE name = ?;";
$name_statement = $conn->prepare($name_query);
$name_statement->execute([$name]);

if (count($name_statement->fetchAll()) > 0) {
  Error("[ERROR] A poll with that name already exists");
}

//Get the time
$date = new DateTime();



//
//Build SQL Query
//
$sql = "INSERT INTO polls (name, upvotes, created, author, description) VALUES (?, 0, ?, ?, ?);SELECT SCOPE_IDENTITY();";
$statement = $conn->prepare($sql);
$result = $statement->execute([$name, $date->getTimestamp(), $_SESSION["id"], $desc]);

if ($result === False) {
  echo("There was an error submitting your poll");
}

Logger::Log($conn, $_SESSION["id"], "SUBMIT_POLL", $name);

die("Success");
