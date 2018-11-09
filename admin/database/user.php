<?php namespace Opinionated;
//Make sure only admins can access it
require("../../include/permissions/admin_only.php");
require("../../include/sql/sql.php");


if (!isset($_GET["id"])) {
  header("Location: ./users");
}


//
// Setup page settings
//
$TITLE = "Opinionated | Admin Interface";
$NAV_TAB = "database";
include("../../include/html/admin_layout.php");

$id = $_GET["id"];

$q = "SELECT * FROM users WHERE id = ?;";
$st = $conn->prepare($q);
$st->execute([$id]);

$row = $st->fetch();

$email = $row->email;

?>
<style>
.admin-menu-users {
  background-color: rgba(0, 0, 0, 0.25) !important;
}
</style>
<<<<<<< HEAD
<script>
var id = <?php echo($row->id); ?>;
</script>
=======
>>>>>>> master
<div class="container center">
  <h1>USER #<?php echo($id); ?></h1>
</div>
<div class="container">
  <div class="row">
    <table class="table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Display Name</th>
        <th>Email</th>
        <th>Rank</th>
        <th>Account Type</th>
        <th>Verified</th>
        <th>Blocked Reports</th>
        <th>Subscribed Emails</th>
        <th>Banned</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><?php echo($row->id); ?></td>
        <td><?php echo($row->username); ?></td>
        <td><?php echo($row->display_name); ?></td>
        <td><?php echo($row->email); ?></td>
        <td><?php echo($row->rank); ?></td>
        <td><?php echo($row->account_type); ?></td>
        <td><?php echo($row->verified == "0" ? "FALSE" : "TRUE"); ?></td>
        <td><?php echo($row->reports_blocked == "0" ? "FALSE" : "TRUE"); ?></td>
        <td><?php echo($row->subscribed_emails == "0" ? "FALSE" : "TRUE"); ?></td>
        <td><?php echo($row->banned == "0" ? "FALSE" : "TRUE"); ?></td>
      </tr>
    </tbody>
  </table>
  </div>
  <div class="row actions">
    <div class="col-6">
      <h6 onclick="showAction('ban');" id="btn-action1" class="center cursor full btn btn-primary">Ban User</h6>
    </div>
    <div class="col-6">
      <h6 onclick="showAction('warn');" id="btn-action2" class="center cursor full btn btn-primary">Warn User</h6>
    </div>
  </div>
  <script>
  function showAction(action) {
    $("#" + action)[0].style.display = "block";

    $(".actions")[0].style.display = "none";
  }
  function reportAction(button, action) {
    var reason = button.form.children[1].textContent;

    sendRequest(action, {xsrf: xsrf, reason: reason, id: id});
  }
  </script>
  <form method="post" action="" id="ban" style="display: none;" class="row">
    <label for="delete-reason" class="primary">Message</label>
    <textarea form="delete" rows="15" class="text form-control" name="reason"><?php require("../../docs/notices/account_banned.php"); ?></textarea>
    <br>
    <input class="form-control btn-primary" type="submit" onclick="reportAction(this, '/api/users/ban');return false;" value="BAN ACCOUNT">
  </form>
  <form method="post" action="/api/users/warn" id="warn" style="display: none;" class="row">
    <label for="delete-reason" class="primary">Message</label>
    <textarea form="delete" rows="15" class="text form-control" name="reason"><?php require("../../docs/notices/warn.php"); ?></textarea>
    <br>
    <input class="form-control btn-primary" type="submit" value="WARN ACCOUNT">
  </form>
</div>
