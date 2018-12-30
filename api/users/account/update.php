<?php
//Start the session
session_start();

require(__DIR__ . "/../../../include/permissions/check_xsrf.php");
require(__DIR__ . "/../../../include/permissions/user_only.php");
require(__DIR__ . "/../../../include/sql/sql.php");
require(__DIR__ . "/../../../include/permissions/Logger.php");


//Verify password
if ($_SESSION["account_type"] === "account") {
  //Create sql query
  $query = "SELECT password FROM users WHERE id = ?;";

  $statement = $conn->prepare($query);
  $statement->execute([$_SESSION["id"]]);

  $info = $statement->fetch();

  if (!isset($info)) {
    die("Invalid user id");
  }

  $pass = $info->password;

  $result = password_verify($_POST["password"], $pass);

  if ($result === False) {
    die("Incorrect Password");
  }
}


//
// Update data
//
$query = "UPDATE users SET email = ? WHERE id = ?";
$statement = $conn->prepare($query);
$statement->execute([htmlspecialchars($_POST["email"]), $_SESSION["id"]]);

if ($statement->rowCount() !== 0) {
  //Updated email
  Logger::Log($conn, $_SESSION["id"], "CHANGE_EMAIL", $_POST["email"]);
}

$query = "UPDATE users SET display_name = ? WHERE id = ?";
$statement = $conn->prepare($query);
$statement->execute([htmlspecialchars($_POST["display_name"]), $_SESSION["id"]]);

if ($statement->rowCount() !== 0) {
  //Updated email
  Logger::Log($conn, $_SESSION["id"], "CHANGE_DISPLAY_NAME", $_POST["display_name"]);
}

$_SESSION["email"] = htmlspecialchars($_POST["email"]);
$_SESSION["display_name"] = htmlspecialchars($_POST["display_name"]);


die("Success");
