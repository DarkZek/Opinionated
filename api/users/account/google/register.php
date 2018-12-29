<?php
require("/var/www/html/vendor/autoload.php");

//
// Load user info
//
$email = $pay_load["email"];
$display_name = $userinfo["displayName"];

if (trim($display_name) === "") {
  $display_name = $email;
}

//TODO: Make sure this is secure
$password = $pay_load["sub"];


//
// Insert user into database
//
$query = "INSERT INTO users (username, display_name, email, account_type, password, verified, rank) VALUES (?, ?, ?, 'google', ?, 1, 0);";
$statement = $conn->prepare($query);
$result = $statement->execute([$email, $display_name, $email, $password]);

if ($result === False) {
  Error("[ERROR] We're having a database problem right now. Try again later or contact us!");
}


//
// Get user information
//
$info_query = "SELECT * FROM users WHERE password = ?";
$info_statement = $conn->prepare($info_query);
$info_statement->execute([$password]);
$info = $info_statement->fetch();


//
// Setup session
//

//Success! Login them in
$_SESSION["display_name"] = $display_name;
$_SESSION["id"] = $info->id;
$_SESSION["account_type"] = "google";
$_SESSION["seen_post_register"] = "0";
$_SESSION["verified"] = True;
$_SESSION["rank"] = 0;

//Generate xsrf token
$_SESSION["xsrf_token"] = md5(uniqid(rand(), true));

//Redirect
header("Location: /");
