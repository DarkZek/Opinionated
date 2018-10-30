<?php
require("/var/www/html/vendor/autoload.php");

session_start();

if (!isset($_GET["code"])) {
  $_SESSION["error"] = "[ERROR] No google account token provided";
  header("Location: /login");
  die();
}

if (!isset($pay_load)) {
  //Get google account info
  $g_client = new Google_Client();
  $g_client->setClientId("594557677828-ecb05iv4dfhepddc1sg0ovq8ohlq2iod.apps.googleusercontent.com");
  $client_secret = trim(file_get_contents("../../../../docs/accounts/google_secret.txt"));
  $g_client->setClientSecret($client_secret);
  $g_client->setRedirectUri("https://opinionated.nz/api/users/account/google/login");
  $g_client->setScopes(Google_Service_Plus::PLUS_ME);

  try {
    $token = $g_client->fetchAccessTokenWithAuthCode($_GET['code']);
    $g_client->setAccessToken($token);
  }catch (Exception $e){
    $_SESSION["error"] = "[ERROR] " . $e->getMessage() . $_GET['code'];
    header("Location: /login");
    die();
  }

  try {
    $pay_load = $g_client->verifyIdToken();
  }catch (Exception $e) {
    $_SESSION["error"] = "[ERROR] " .$e->getMessage();
    header("Location: /register");
    die();
  }

  $service = new Google_Service_Plus($g_client);

  $userinfo = $service->people->get('me');

  $email = $pay_load["email"];
  $display_name = $userinfo["displayName"];
  $password = $pay_load["sub"];
}

//Connect to mysql database
include_once("/var/www/html/include/sql/sql.php");

//Create sql query
$query = "SELECT * FROM users WHERE email = ? AND password = ?;";

$statement = $conn->prepare($query);
$statement->execute([$email, $password]);

$info = $statement->fetchAll();

if (!isset($info[0])) {
  //Register account - not login!
  require("/var/www/html/include/geo/nz_only.php");
  require("/var/www/html/api/users/account/google/register.php");
  die();
}

$_SESSION["display_name"] = $info[0]->display_name;
$_SESSION["email"] = $info[0]->email;
$_SESSION["id"] = $info[0]->id;
$_SESSION["seen_post_register"] = $info[0]->seen_post_register;
$_SESSION["account_type"] = "google";
$_SESSION["verified"] = True;
$_SESSION["xsrf_token"] = md5(uniqid(rand(), true));
$_SESSION["rank"] = $info[0]->rank;

header("Location: /");
