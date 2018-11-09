<?php namespace Opinionated;
//Make sure only admins can access it
require("/var/www/html/include/permissions/admin_only.php");


//
// Setup page settings
//
$TITLE = "Opinionated | Admin Interface";
$NAV_TAB = "main";
require("/var/www/html/include/html/admin_layout.php");
require("/var/www/html/include/sql/sql.php");


//
//Get leading poll
//
$q = "SELECT * FROM polls ORDER BY upvotes DESC LIMIT 1;";
$st = $conn->prepare($q);
$st->execute();
$top_poll = $st->fetch()->name;


//
//Get user count
//
$q = "SELECT COUNT(*) FROM users;";
$st = $conn->prepare($q);
$st->execute();
$user_count = $st->fetchColumn();


//
//Get poll count
//
$q = "SELECT COUNT(*) FROM polls;";
$st = $conn->prepare($q);
$st->execute();
$poll_count = $st->fetchColumn();

?>
<style>
.admin-menu-dashboard {
  background-color: rgba(0, 0, 0, 0.25) !important;
}
</style>
<div>
  <div class="row">
    <div class="col-4">
      <div class="card center dashboard-stat">
        <h2>Current Leading Poll</h2>
        <a><?php echo($top_poll); ?></a>
      </div>
      <div class="card cursor" onclick="document.location = '/api/main_poll/update.php';">
        <a>UPDATE MAIN POLL</a>
      </div>
    </div>
    <div class="col-4">
      <div class="card center dashboard-stat cursor" onclick="document.location = '/admin/database/user';">
        <br>
        <h2><?php echo($user_count); ?> Users</h2>
      </div>
    </div>
    <div class="col-4">
      <div class="card center dashboard-stat">
        <br>
        <h2><?php echo($poll_count); ?> Polls</h2>
      </div>
    </div>
  </div>
</div>
