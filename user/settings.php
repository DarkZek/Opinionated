<?php namespace Opinionated;


$NAV_TAB = "";
$TITLE = "Opinionated | Settings";
require("../include/html/default_layout.php");
//Make sure a user is logged in
require("../include/permissions/user_only.php");
require("../include/sql/sql.php");


//
// Get user info
//
$user_query = "SELECT display_name,username,email FROM users WHERE id = ?;";
$user_statement = $conn->prepare($user_query);
$user_statement->execute([$_SESSION["id"]]);
$user = $user_statement->fetch();

?>
<script src="/js/settings.js"></script>
<link href="/css/user/settings.css" rel="stylesheet">
<div class="header">
  <div class="container">
    <h1 class="center">USER SETTINGS</h1>
  </div>
</div>
<div class="container">
  <div class="row">
    <div class="col-3">
      <div class="row menu-item perspective-menu-item" onclick="showSettings('#user', this);">
        <a>Account Settings</a>
      </div>
      <div class="row menu-item request-menu-item" onclick="showSettings('#request', this);">
        <a>Request Help</a>
      </div>
      <div class="row menu-item privacy-menu-item" onclick="showSettings('#privacy', this);">
        <a>Privacy & EULA</a>
      </div>
      <div class="row menu-item delete-menu-item" onclick="showSettings('#delete', this);">
        <a>Delete Account</a>
      </div>
    </div>
    <div class="col-1"></div>
    <div class="col-8 pages-container">
      <!-- Each item is a different slide -->
      <div id="delete" style="display: none;">
        <br>
        <h1 class="center">Sorry to see you go!</h1>
        <div class="divider"></div>
        <a> When you delete your Opinionated account all of your personal details (email, name, perspectives, votes) will be <b class="red">deleted</b>. Polls you have voted on will not be affected by your votes being deleted as only the record of you voting on the poll is removed - not the amount of votes.</a>
        <br>
        <br>
        <a class="btn b-red white form-control" onclick="showDialogue('/api/html/delete_account');">DELETE ACCOUNT</a>
      </div>
      <div id="user" style="display: none;">
        <br>
        <h1>User Settings</h1>
        <div class="divider"></div>
        <div>
          <label for="username" class="primary">Username</label>
          <input type="text" class="form-control" disabled name="username" value="<?php echo(htmlspecialchars($user->username)); ?>">
          <label for="display_name" class="primary">Display Name</label>
          <input type="text" class="form-control" name="display_name" value="<?php echo(htmlspecialchars($user->display_name)); ?>">
          <label for="email" class="primary">Email</label>
          <input type="text" class="form-control" name="email" value="<?php echo(htmlspecialchars($user->email)); ?>">
          <div class="divider"></div>
          <br>
          <form>
            <label for="password" class="primary">Password</label>
            <input type="password" class="form-control" name="password">
            <br>
            <input class="btn btn-primary form-control" type="submit" onclick="" value="APPLY CHANGES">
          <form>
        </div>
        <br>
      </div>
      <div id="request" style="display: none;">
        <br>
        <h1 class="center">Request Help</h1>
        <div class="divider"></div>
        <h6 class="center">If you need help with anything Opinionated or have a query feel free to email us at </h6>
        <br>
        <a href="mailto:opinionatednz@gmail.com" class="primary bold center">opinionatednz@gmail.com</a>
        <br>
      </div>
      <div id="privacy" style="display: none;">
        <br>
        <h1 class="center">Privacy Policy and TOS</h1>
        <div class="divider"></div>
        <h6 class="center">Opinionated dosen't believe in lawyer jargon to hide what we collect from users. We explain it in plain english. You can read Opinionated's privacy policy <a href="/privacy" class="primary bold">here</a> and our TOS <a href="/tos" class="bold primary">here</a></h6>
        <br>
        <h6 class="center">Please email any querys to</h6>
        <a href="mailto:opinionatednz@gmail.com" class="primary bold center">opinionatednz@gmail.com</a>
        <br>
      </div>
    </div>
  </div>
</div>
