<?php
session_start();
//Run
require(__DIR__ . "/../../../include/geo/nz_only.php");

$secret = "6Le1mWEUAAAAAMgM6Ki8Af6awOoqD8Itrdsd4m3U";

function CheckCaptcha($code, $secret) {

  $url = 'https://www.google.com/recaptcha/api/siteverify';

  $data = array('secret' => $secret, 'response' => $code);

  // use key 'http' even if you send the request to https://...
  $options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
    )
  );
  $context  = stream_context_create($options);
  $result = file_get_contents($url, false, $context);
  if ($result === FALSE) {
     die("[ERROR] Incorrect recaptcha result, please try again");
  }

  return $result;
}

//
// Get user settigns
//

//Only require username and password for accounts
if (!isset($_POST["username"])) {
  die("[ERROR] No username set");
}
if (!isset($_POST["password"])) {
  die("[ERROR] No password set" . $_POST["username"] . "t");
}
if (!isset($_POST["display_name"])) {
  die("[ERROR] No display name set");
}
if (!isset($_POST["email"])) {
  die("[ERROR] No email set");
}
if (!isset($_POST["g-recaptcha-response"])) {
  die("[ERROR] No recaptcha set");
}

$username = htmlspecialchars($_POST["username"]);
$password = $_POST["password"];
$display_name = htmlspecialchars($_POST["display_name"]);
$email = htmlspecialchars($_POST["email"]);
$recaptcha = $_POST["g-recaptcha-response"];



//
// Make sure user settings are all correct
//

if ($username === "") {
  die("[ERROR] No username set");
}
if (strlen($username) < 4 || strlen($username) > 25) {
  die("[ERROR] Username too long/short");
}
if ($password === "") {
  die("[ERROR] No password ");
}
if (strlen($password) < 4 || strlen($password) > 25) {
  die("[ERROR] Password too long/short");
}
if ($display_name === "") {
  die("[ERROR] No display name set");
}
if (strlen($display_name) < 4 || strlen($display_name) > 25) {
  die("[ERROR] display name too long/short");
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  die("[ERROR] Invalid email address");
}
if (strlen($email) < 4 || strlen($email) > 50) {
  die("[ERROR] Email address too long/short");
}

//
//Check if captcha matches
//
$response = json_decode(CheckCaptcha($recaptcha, $secret));

if ($response->success === False) {
  die("[ERROR] Invalid recatcha token");
}


//
// Hash password
//
$hash = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);
//Connect to mysql database
require("/var/www/html/include/sql/sql.php");

//
//Check if email is already used
//
$email_query = "SELECT * FROM users WHERE username = ?;";
$email_statement = $conn->prepare($email_query);
$emails = $email_statement->execute([$username]);

if (count($email_statement->fetchAll()) > 0) {
  die("[ERROR] An account with that email address already exists!");
}

//
//Check if username is already used
//
$email_query = "SELECT * FROM users WHERE email = ?;";
$email_statement = $conn->prepare($email_query);
$emails = $email_statement->execute([$email]);

if (count($email_statement->fetchAll()) > 0) {
  die("[ERROR] An account with that username already exists!");
}

//
// Create new user in database
//
$query = "INSERT INTO users (username, display_name, email, rank, account_type, password, verified, reports_blocked, seen_post_register) VALUES (?, ?, ?, 0, 'account', ?, 0, 0, 0);";
$statement = $conn->prepare($query);
$result = $statement->execute([$username, $display_name, $email, $hash]);


//
// Load user Details
//
$info_query = "SELECT * FROM users WHERE username = ?";
$info_statement = $conn->prepare($info_query);
$info_statement->execute([$username]);
$info = $info_statement->fetch();


//
// Send verify email
//

//Generate auth key
$auth = sha1(microtime(true).mt_rand(10000,90000));

$message = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">".
"<html xmlns=\"http://www.w3.org/1999/xhtml\">".
"    <head>".
"        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />".
"        <title>A Simple Responsive HTML Email</title>".
"        <style type=\"text/css\">".
"        body {margin: 0; padding: 0; min-width: 100%; !important;}".
"        .content {width: 100%; max-width: 600px;}".
"        .center {text-align: center; width: 100%;}".
"        a {display: block; padding-top: 0px;}".
"        </style>".
"    </head>".
"    <body yahoo bgcolor=\"#f6f8f1\">".
"        <div style='width: 100%; background-color: #57BF37;'>".
"          <h1 class='center' style='color:white;'>WELCOME TO OPINIONATED!</h1>".
"        </div>".
"        <a class='center'>To verify your account please navigate to</a>".
"        <a style='text-align: center; width: 100%;' href='https://opinionated.nz/api/users/verify?key=" . $auth . "&u=" . $info->id . "'>opinionated.nz/api/users/verify?key=" . $auth . "&u=" . $info->id . "</a>".
"        <a style='text-align: center; width: 100%;'>Thanks!</a>".
"        <a style='text-align: center; width: 100%;'>- The Opinionated Team!</a>".
"    </body>".
"</html>";

//
// Add to mail queue
//
$email_query = "INSERT INTO send_emails (content, receiver, title, sender) VALUES (?, ?, ?, ?);";
$statement = $conn->prepare($email_query);
$statement->execute([$message, $email, "Welcome to Opinionated!", 0]);


//
//Add verify key to database
//
$query = "INSERT INTO verify_user_keys (user_id, verification_key) VALUES (?, ?);";
$statement = $conn->prepare($query);
$result = $statement->execute([$info->id, $auth]);



//Success! Login them in
$_SESSION["username"] = $username;
$_SESSION["display_name"] = $display_name;
$_SESSION["id"] = $info->id;
$_SESSION["seen_post_register"] = "0";
$_SESSION["account_type"] = "account";
$_SESSION["rank"] = 0;
$_SESSION["verified"] = False;
$_SESSION["xsrf_token"] = md5(uniqid(rand(), true));

//Redirect
?>
Success
