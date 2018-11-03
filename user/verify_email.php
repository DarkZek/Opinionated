<?php namespace Opinionated;
session_start();

<<<<<<< HEAD
if (!isset($_SESSION["verified"]) || $_SESSION["verified"] === True) {
=======
<<<<<<< HEAD
if (!isset($_SESSION["verified"]) || $_SESSION["verified"] === True) {
=======
<<<<<<< HEAD
if (!isset($_SESSION["verified"]) || $_SESSION["verified"] === True) {
=======
if (!isset($_SESSION["verified"] || $_SESSION["verified"] === True)) {
>>>>>>> master
>>>>>>> master
>>>>>>> master
  header("Location: /");
  die();
}

//Load
include("../include/sql/sql.php");

//
// Check if page has updated
//
$query = "SELECT verified FROM users WHERE id = ?;";
$statement = $conn->prepare($query);
$statement->execute([$_SESSION["id"]]);
$result = $statement->fetch();

if ($result->verified === "1") {
  $_SESSION["verified"] = True;
  header("Location: /");
  die();
}

?>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta charset="UTF-8">
  <link href="/css/bootstrap.min.css" rel="stylesheet">
  <script src="/js/main.js"></script>
  <script src="/js/jquery.min.js"></script>
  <script src="/js/bootstrap.min.js"></script>
  <link href="/css/main.css" rel="stylesheet">
  <!-- Compiled and minified CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-rc.2/css/materialize.min.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"><link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/brands.css" integrity="sha384-7xAnn7Zm3QC1jFjVc1A6v/toepoG3JXboQYzbM0jrPzou9OFXm/fY6Z/XiIebl/k" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/fontawesome.css" integrity="sha384-ozJwkrqb90Oa3ZNb+yKFW2lToAWYdTiF1vt8JiH5ptTGHTGcN7qdoR1F95e0kYyG" crossorigin="anonymous">
  <title>Opinionated | Verify Email</title>
  </head>
<body>
<style>
i {
  width: 100%;
  font-size: 200px !important;
  color: gray;
  text-align: center;
}
.container {
  margin-top: 10%;
}
</style>

<div class="container">
  <i class="material-icons">email</i>

  <h2 class="center">Check your emails to verify your account!</h2>
  <h6 class="center">(Dont forget to check your spam folder)</h6>
  <h4 class="center">Refresh this page once you've verified your account to begin using Opinionated!</h4>

  <div class="progress">
      <div class="indeterminate"></div>
  </div>
</div>
<script>

//Every 15 seconds
setInterval(rl, 15000);

function rl() {
  location.reload(true);
}
</script>
<body>
