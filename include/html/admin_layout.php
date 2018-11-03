<?php namespace Opinionated;

require(__DIR__ . "/html_structure.php");

if (isset($_SESSION["display_name"])) {
  $username = $_SESSION["display_name"];
}

//Nav bar
?>
<script src="/js/admin.js"></script>
<link href="/css/admin.css" rel="stylesheet">
<script>var xsrf = "<?php if (isset($_SESSION["xsrf_token"])) {echo($_SESSION["xsrf_token"]);} ?>";</script>
<nav class="navbar navbar-expand-lg navbar-light b-primary">
  <div class="col-2">
    <a href="/"><img class="opinionated-logo" src="/images/opinionated_black_2.png"></a>
  </div>
  <div class="col-3 search">
    <i class="material-icons">search</i>
    <input type="text" class="white" placeholder="Search User" id="user_search">
    <script>
    $("#user_search").on("keydown", function search(e) {
      if(e.keyCode == 13) {
        document.location = "/admin/database/users?search=" + $("#user_search")[0].value;
      }
    });
    </script>
  </div>
  <div class="col-3">
  </div>
  <div class="col-2 notifications">
    <i class="material-icons" href="document.location = '/admin/reports';"><a class="notification-icon">40</a>supervisor_account</i>
  </div>
  <div class="col-2">
    <?php require(__DIR__ . "/user-dropdown.php"); ?>
  </div>
</nav>
<div class="sidebar row">
  <div class="col-2 b-primary sideselector">
    <div class="row menu-item admin-menu-dashboard" onclick="document.location = '/admin/';">
      <a>Dashboard</a>
    </div>
    <div class="row menu-item admin-menu-statistics" onclick="">
      <a>Statistics</a>
    </div>
    <div class="row menu-item admin-menu-reports" onclick="document.location = '/admin/database/reports';">
      <a>Reports</a>
    </div>
    <div class="row menu-item admin-menu-users" onclick="document.location = '/admin/database/users';">
      <a>Users</a>
    </div>
    <div class="row menu-item admin-menu-feedback" onclick="">
      <a>Feedback</a>
    </div>
    <div class="row menu-item admin-menu-sponsors" onclick="">
      <a>Sponsors</a>
    </div>
  </div>
  <div class="col-10" style="overflow: auto;">
    <br>
