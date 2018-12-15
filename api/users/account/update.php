<?php
//Start the session
session_start();

require(__DIR__ . "/../../../include/permissions/check_xsrf.php");
require(__DIR__ . "/../../../include/permissions/user_only.php");
require(__DIR__ . "/../../../include/sql/sql.php");


//Verify password
if ($_SESSION["account_type"] === "account") {
  //Create sql query
  $query = "SELECT * FROM users WHERE id = ? AND password = ?;";

  $statement = $conn->prepare($query);
  $statement->execute([$_SESSION["id"], $_POST["password"]]);

  $info = $statement->fetchAll();

  if (!isset($info[0])) {
    die("Invalid login");
  }
}


//
// Update data
//
$query = "UPDATE users SET email = ?, display_name = ? WHERE id = ?";
$statement = $conn->prepare($query);
$statement->execute([htmlspecialchars($_POST["email"]), htmlspecialchars($_POST["display_name"]), $_SESSION["id"]]);

$_SESSION["email"] = htmlspecialchars($_POST["email"]);
$_SESSION["display_name"] = htmlspecialchars($_POST["display_name"]);


die("Success");
