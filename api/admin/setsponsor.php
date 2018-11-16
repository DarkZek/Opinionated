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

//Create sql query
$query = "UPDATE sponsor_spots SET image_url = ?, message = ?, title = ? WHERE id = ?;";
$statement = $conn->prepare($query);
$result = $statement->execute([$_POST["image"], $_POST["content"], $_POST["title"], $_POST["sponsor"]]);

if ($result !== True) {
  die("Could not complete the action");
}

die("Success");
