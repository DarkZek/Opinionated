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
} else {
  die("Cannot change google accounts password");
}

$password = password_hash($_POST["newpassword"], PASSWORD_DEFAULT, ['cost' => 12]);

//
// Update data
//
$query = "UPDATE users SET password = ? WHERE id = ?";
$statement = $conn->prepare($query);
$statement->execute([htmlspecialchars($password), $_SESSION["id"]]);

Logger::Log($conn, $_SESSION["id"] . "", "CHANGE_PASSWORD");

die("Success");
