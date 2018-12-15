<?php namespace Opinionated;

//Make sure only admins can access it
require("../../include/permissions/admin_only.php");

//Only allow New Zealanders to vote
require("../../include/geo/nz_only.php");

require("../../include/permissions/check_xsrf.php");
require("../../include/sql/sql.php");

if (!isset($_POST["sponsor"])) {
  die("No input sponsor id");
}

if (!isset($_POST["title"])) {
  die("No input title");
}

if (!isset($_POST["image"])) {
  die("No input image");
}

if (!isset($_POST["content"])) {
  die("No input content");
}

if (!strlen($_POST["content"]) > 200) {
  die("Content length too long");
}

//Create sql query
$query = "UPDATE sponsor_spots SET image_url = ?, message = ?, title = ? WHERE id = ?;";
$statement = $conn->prepare($query);
$result = $statement->execute([htmlspecialchars($_POST["image"]), htmlspecialchars($_POST["content"]), htmlspecialchars($_POST["title"]), htmlspecialchars($_POST["sponsor"])]);

if ($result !== True) {
  die("Could not complete the action");
}

die("Success");
