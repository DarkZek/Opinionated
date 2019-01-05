<?php
session_start();

if (!isset($_POST["username"])) {
  die("We cant find an account with that username and password");
  die();
}
if (!isset($_POST["password"])) {
  die("We cant find an account with that username and password");
}

$username = htmlspecialchars($_POST["username"]);
$password = $_POST["password"];

if ($username === "") {
  die("We cant find an account with that username and password");
}

//Connect to mysql database
require("/var/www/html/include/sql/sql.php");

//If they're logging in using email change the query
$email_login = filter_var($username, FILTER_VALIDATE_EMAIL);

//Create sql query
if ($email_login) {
  $query = "SELECT * FROM users WHERE email = ?;";
} else {
  $query = "SELECT * FROM users WHERE username = ?;";
}

$statement = $conn->prepare($query);
$statement->execute([$username]);
$result = $statement->fetchAll();

if (count($result) == 0) {
  die("We cant find an account with that username and password");
}

//Check if its a google account
if ($result[0]->account_type === "google") {
  die("We cant find an account with that username and password");
}

$checked = password_verify($password, $result[0]->password);

if ($checked === False) {
  die("We cant find an account with that username and password");
}

if ($result[0]->banned == "1") {
  die("Your account has been banned");
}

$_SESSION["username"] = $result[0]->username;
$_SESSION["display_name"] = $result[0]->display_name;
$_SESSION["id"] = $result[0]->id;
$_SESSION["seen_post_register"] = $result[0]->seen_post_register;
$_SESSION["account_type"] = "account";
$_SESSION["rank"] = $result[0]->rank;
$verified = False;
if ($result[0]->verified === 1) {
  $verified = True;
}
$_SESSION["verified"] = $verified;
$_SESSION["xsrf_token"] = md5(uniqid(rand(), true));

echo("Success");
