<?php
//Make sure a user is logged in
require("/var/www/html/include/permissions/user_only.php");

$NAV_TAB = "";
$TITLE = "Have it your way";
require("/var/www/html/include/html/default_layout.php");

?>
<script>
function showSettings(settings, obj) {
  document.location.hash = settings;
  //Disable all
  $("#delete")[0].style.display = "none";
  $("#request")[0].style.display = "none";
  $("#perspective")[0].style.display = "none";
  $("#privacy")[0].style.display = "none";

  //Enable the one we want
  $(settings)[0].style.display = "block";

  //Remove selected tag
  if ($(".selected").length > 0) {
    $(".selected")[0].classList.remove("selected");
  }
  obj.classList.add("selected");
}

$(document).ready(function() {
  var fragment = window.location.hash.substr(1);
  if (fragment != "") {
    showSettings("#" + fragment, $("." + fragment + "-menu-item")[0]);
  } else {
    showSettings("#perspective", $(".perspective-menu-item")[0]);
  }
});
</script>
<link href="/css/user/settings.css" rel="stylesheet">
<div class="header">
  <div class="container">
    <h1 class="center">USER SETTINGS</h1>
  </div>
</div>
<div class="container">
  <div class="row">
    <div class="col-3 b-gray">
      <div class="row menu-item perspective-menu-item" onclick="showSettings('#perspective', this);">
        <a>Perspective Settings</a>
      </div>
      <div class="row menu-item poll-menu-item" onclick="showSettings('#poll', this);">
        <a>Poll Settings</a>
      </div>
      <div class="row menu-item request-menu-item" onclick="showSettings('#request', this);">
        <a>Request Help</a>
      </div>
      <div class="row menu-item account-menu-item" onclick="showSettings('#account', this);">
        <a>Account Settings</a>
      </div>
      <div class="row menu-item privacy-menu-item" onclick="showSettings('#privacy', this);">
        <a>Privacy & EULA</a>
      </div>
      <div class="row menu-item delete-menu-item" onclick="showSettings('#delete', this);">
        <a>Delete Account</a>
      </div>
    </div>
    <div class="col-1"></div>
    <div class="col-8">
      <div id="delete" style="display: none;">
        <br>
        <h1 class="center">Sorry to see you go!</h1>
        <a> When you delete your Opinionated account all of your personal details (email, name, perspectives, votes) will be <b class="red">deleted</b>. Polls you have voted on will not be affected by your votes being deleted as only the record of you voting on the poll is removed - not the amount of votes.</a>
        <br>
        <div class="password" <?php if ($_SESSION["account_type"] === "google") {echo("hidden");} ?>>
          <br>
          <label class="form-check-label" for="delete-password">Password</label>
          <input type="password" id="delete-password" required name="delete-password" class="form-control">
          <a class="red delete-password-error"></a>
        </div>
        <br>
        <a class="btn b-red white form-control" onclick="sendRequest('/api/users/account/delete', {password: $('#delete-password')[0].value}, onDelete);">DELETE ACCOUNT</a>
        <script>
        function onDelete(data) {
          if (data == "[ERROR] Invalid Password") {
            $(".delete-password-error")[0].textContent = "Invalid Password! Please try again";
          } else if (data == "Success") {
            document.location = "/";
          }
        }
        </script>
      </div>
      <div id="perspective" style="display: none;">
        <br>
        <h1 class="center">Perspective Settings!</h1>
        <a>View all of your perspectives</a>
        <br>
      </div>
      <div id="request" style="display: none;">
        <br>
        <h1 class="center">Request Help</h1>
        <h6 class="center">If you need help with anything Opinionated or have a query feel free to email us at </h6>
        <br>
        <a href="mailto:opinionatednz@gmail.com" class="primary bold center">opinionatednz@gmail.com</a>
        <br>
      </div>
      <div id="privacy" style="display: none;">
        <br>
        <h1 class="center">Privacy Policy and EULA</h1>
        <h6 class="center">Opinionated dosen't believe in lawyer jargon to hide what we collect from users. We explain it in plain english. You can read Opinionated's privacy policy <a href="/privacy" class="primary bold">here</a> and our EULA <a href="/eula" class="bold primary">here</a></h6>
        <br>
        <h6 class="center">Please email any querys to</h6>
        <a href="mailto:opinionatednz@gmail.com" class="primary bold center">opinionatednz@gmail.com</a>
        <br>
      </div>
    </div>
  </div>
</div>
