<?php
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


//
//Get poll reports
//
$q = "SELECT COUNT(*) FROM poll_reports;";
$st = $conn->prepare($q);
$st->execute();
$reports_count = $st->fetchColumn();


?>
<div class="header">
  <div class="container center">
    <h1>WEBSITE STATUS</h1>
  </div>
</div>
<div class="container">
  <div class="row">
    <div class="col-4">
      <br>
      <a class="btn btn-primary form-control" href="/api/update_main_poll.php">UPDATE MAIN POLL</a>
    </div>
    <div class="col-4">
      <div class="" >
        <h2 class="center">SET ADMIN RANK</h2>
        <label class="form-check-label" for="set-admin">Username</label>
        <input type="text" id="set-admin" name="set-admin" class="form-control">
        <br>
        <script>function setRankDone(data) {if (data == "Success") {alert("Successfully set rank");} else {alert("There was an error setting the rank");}}</script>
        <a class="btn btn-primary form-control" onclick="sendRequest('/api/users/set_rank', {username: $('#set-admin')[0].value, rank: 1}, setRankDone);return false;">SET ADMIN</a>
      </div>
    </div>
    <div class="col-4">
      <div class="container">
        <table class="table table-condensed">
          <thead>
            <tr>
              <th>Object</th>
              <th>Value</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Current Leading Poll</td>
              <td><?php echo($top_poll); ?></td>
            </tr>
            <tr>
              <td>Users</td>
              <td><?php echo($user_count); ?></td>
            </tr>
            <tr>
              <td>Polls</td>
              <td><?php echo($poll_count); ?></td>
            </tr>
            <tr>
              <td>Poll Reports</td>
              <td><?php echo($reports_count); ?></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
