<?php namespace Opinionated;

require(__DIR__ . "/html_structure.php");
require_once(__DIR__ . "/../sql/sql.php");

if (isset($_SESSION["display_name"])) {
  $username = $_SESSION["display_name"];
}

$reports_q = "SELECT * FROM poll_reports;";
$reports_st = $conn->prepare($reports_q);
$reports_st->execute([$id]);

$reports = $reports_st->rowCount();

//Nav bar
?>
<script src="/js/admin.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
<link href="/css/admin.css" rel="stylesheet">
<script>var xsrf = "<?php if (isset($_SESSION["xsrf_token"])) {echo($_SESSION["xsrf_token"]);} ?>";</script>
<nav class="navbar navbar-expand-lg navbar-light b-primary">
  <div class="col-2">
    <a href="/" class="center"><img class="opinionated-logo" src="/images/opinionated_white_2.png"></a>
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

  </div>
  <div class="col-2" style="height: 100%;">
    <div class="row right" style="height: 100%;">
      <div class="notifications">
        <i class="material-icons" onclick="document.location = '/admin/database/reports';">
          <?php if ($reports != 0) {
            echo('<a class="notification-icon">');
            echo($reports);
            echo('</a>');
          } ?>
        supervisor_account</i>
      </div>
      <div style="padding-top: 6px;">
        <?php require(__DIR__ . "/user-dropdown.php"); ?>
      </div>
    </div>
  </div>
</nav>
<div class="sidebar row">
  <div class="col-2 b-primary sideselector">
  <div class="row made-by">
    <a class="white" href="https://github.com/darkzek/">Made by Marshall Ashdowne</a>
  </div>
    <div class="row menu-item admin-menu-dashboard" onclick="document.location = '/admin/';">
      <a>Dashboard</a>
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
    <div class="row menu-item admin-menu-sponsors" onclick="document.location = '/admin/sponsors';">
      <a>Sponsors</a>
    </div>
  </div>
  <div class="col-10" style="overflow: auto;">
    <script>
    <br>
