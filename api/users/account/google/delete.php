<?php
//Start the session
session_start();

require(__DIR__ . "/../../../include/permissions/check_xsrf.php");
require(__DIR__ . "/../../../include/permissions/user_only.php");
require(__DIR__ . "/../../../include/sql/sql.php");

//
// Verify password if its not a google account
//
  if (!isset($_GET["code"])) {
    die("No google account token provided");
  }

  if (!isset($pay_load)) {
    //Get google account info
    $g_client = new Google_Client();
    $g_client->setClientId("594557677828-ecb05iv4dfhepddc1sg0ovq8ohlq2iod.apps.googleusercontent.com");
    $client_secret = trim(file_get_contents("../../../../docs/accounts/google_secret.txt"));
    $g_client->setClientSecret($client_secret);
    $g_client->setRedirectUri("https://" . $_SERVER['SERVER_NAME'] . "/api/users/account/google/login");
    $g_client->setScopes(Google_Service_Plus::PLUS_ME);

    try {
      $token = $g_client->fetchAccessTokenWithAuthCode($_GET['code']);
      $g_client->setAccessToken($token);
    }catch (Exception $e){
      die("Error checking authentication");
    }

    $pay_load = $g_client->verifyIdToken();

    $service = new Google_Service_Plus($g_client);

    $userinfo = $service->people->get('me');

    $email = $pay_load["email"];
    $display_name = $userinfo["displayName"];
    $password = $pay_load["sub"];
  }

  //Create sql query
  $query = "SELECT * FROM users WHERE email = ? AND password = ?;";

  $statement = $conn->prepare($query);
  $statement->execute([$email, $password]);

  $info = $statement->fetchAll();

  if (!isset($info[0])) {
    die("Invalid login");
  }


//
// Delete data from database
//
$query = "DELETE FROM users WHERE id = ?";
$statement = $conn->prepare($query);
$statement->execute([$_SESSION["id"]]);


//Delete session
session_destroy();


session_start();
$_SESSION["error"] = "Deleted Account";

die("Success");
