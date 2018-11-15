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
<script>
var id = <?php echo($row->id); ?>;
</script>
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
        <th>Reports Blocked</th>
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
        <td id="user_rank"><?php echo($row->rank); ?></td>
        <td><?php echo($row->account_type); ?></td>
        <td><a class="center"><?php echo($row->verified == "0" ? "❌" : "✔️"); ?></a></td>
        <td><a class="center"><?php echo($row->reports_blocked == "0" ? "❌" : "✔️"); ?></a></td>
        <td><a class="center"><?php echo($row->subscribed_emails == "0" ? "❌" : "✔️"); ?></a></td>
        <td><a class="center"><?php echo($row->banned == "0" ? "❌" : "✔️"); ?></a></td>
      </tr>
    </tbody>
  </table>
  </div>
  <div class="row actions">
    <?php if ($row->banned == "0") { ?>
    <div class="col-4">
      <h6 onclick="showAction('ban');" id="btn-action1" class="center cursor full btn btn-primary">Ban User</h6>
    </div>
    <div class="col-4">
      <h6 onclick="showAction('setrank');" id="btn-action3" class="center cursor full btn btn-primary">Change Rank</h6>
    </div>
    <div class="col-4">
      <h6 onclick="showAction('warn');" id="btn-action2" class="center cursor full btn btn-primary">Warn User</h6>
    </div>
    <?php } else { ?>
    <div class="col-12">
      <h6 onclick="sendRequest('/api/users/unban', {id: <?php echo($row->id); ?>}, function(data) { location.reload(); });" class="center cursor full btn btn-primary">Unban User</h6>
    </div>
    <?php } ?>
  </div>
  <script>
  function showAction(action) {
    $("#" + action)[0].style.display = "block";

    $(".actions")[0].style.display = "none";
  }
  function reportAction(button, action) {
    var reason = button.form.children[1].textContent;

    sendRequest(action, {xsrf: xsrf, reason: reason, id: id}, function(data) {
      location.reload();
    });
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
  <div method="post" action="/api/users/setrank" id="setrank" style="display: none;" class="row">
    <label for="delete-reason" class="primary">Set Account Rank</label>
    <select class="form-control" id="user_set_rank">
      <option value="0" <?php if ($row->rank == "0") {echo("selected=\"selected\""); } ?> >User</option>
      <option value="1" <?php if ($row->rank == "1") {echo("selected=\"selected\""); } ?> >Moderator</option>
      <option value="10" <?php if ($row->rank == "10") {echo("selected=\"selected\""); } ?> >Administrator</option>
    </select>
    <br>
    <input class="form-control btn-primary" type="submit" onclick="setRank();" value="SET RANK">
    <script>
    function setRank() {
      var selectedIndex = $("#user_set_rank")[0].options.selectedIndex;
      var rank = $("#user_set_rank")[0][selectedIndex].value;
      setRankTo(rank);
    }

    var oldRank = 0;
    function setRankTo(rank) {
      oldRank = $("#user_rank")[0].textContent;

      sendRequest("/api/users/setrank", {id: id, rank: rank}, function(data) {
        if (data == "Success") {
          showNotification("Changed users rank", "UNDO", function() {
            sendRequest("/api/users/setrank", {id: id, rank: oldRank}, function() {
              showNotification("Successfully undid rank change");
            });
            $("#user_rank")[0].textContent = oldRank;
          });
        } else {
          showNotification(data);
        }
      });
      $("#setrank")[0].style.display = "none";
      $("#user_rank")[0].textContent = rank;
    }
    </script>
  </div>
</div>
