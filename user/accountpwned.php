<?php namespace Opinionated;

session_start();

require("../include/permissions/user_only.php");

$NAV_TAB = "ABOUT";
$TITLE = "Opinionated | About";
include("../include/html/head.php");

//TEMP
$_SESSION["email"] = "mashdowne@hotmail.co.nz";

$context = stream_context_create([
    'http'  =>  [
        'user_agent'    =>  'OpinionatedSecurityService'
    ]
]);
$data = json_decode(file_get_contents("https://haveibeenpwned.com/api/v2/breachedaccount/" . $_SESSION["email"], false, $context));
?>

<style>
.item {
  padding: 10px;
  min-height: 150px;
}

.item img {
  display: block;
  max-height: 130px;
  max-width: 100%;
}

.b-primary a {
  color: white;
  font-weight: bold;
}

.continue {
  position: absolute;
  right: 0px;
  top: 0px;
  height: 60px;
  width: 150px;
}

.continue a {
  font-size: 20px;
  font-weight: bold;
  position: absolute;
  top: 0px;
  bottom: 0px;
  margin-top: auto;
  margin-bottom: auto;
  height: 30px;
}

</style>

<link href="/css/about.css" rel="stylesheet">

<div class="header">
  <div class="continue cursor" onclick="document.location = '/';">
    <a>CONTINUE > </a>
  </div>
  <div class="container">
    <h1 class="center">Account Security</h1>
  </div>
</div>
<div class="container">
  <br>
  <p>We care about the security of every user who joins Opinionated, because of this we have detected 4 account breaches on different websites related to your email address. We tell you this so you know if your password has been comprimised so you know not to use it in the future.</p>
  <?php

  foreach($data as $i => $item) {
    //var_dump($item);
    ?>
    <div class="divider"></div>
    <div class="item row">
      <div class="col-2">
        <div class="">
          <img src="<?php echo($item->LogoPath); ?>">
        </div>
      </div>
      <div class="col-10">
        <h1><?php echo($item->Name); ?></h1>
        <a style="color: grey;"><?php echo(substr($item->ModifiedDate, 0, 10) . " | " . number_format($item->PwnCount) . " Users Affected"); ?></a>
        <p><?php echo($item->Description); ?></p>
      </div>
    </div>
    <?php
  }
  ?>
  <div class="divider"></div>
  <a href="https://haveibeenpwned.com/" class="primary">Powered by https://haveibeenpwned.com/</a>
</div>
