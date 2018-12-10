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

$q = "SELECT * FROM polls WHERE id = ?;";
$st = $conn->prepare($q);
$st->execute([$id]);

$row = $st->fetch();

$email = $row->email;

//Get views
$q = "SELECT COUNT(*) FROM poll_upvotes WHERE poll_id = ? UNION SELECT poll_id FROM poll_skips WHERE poll_id = ?;";
$st = $conn->prepare($q);
$st->execute([$id, $id]);

$views = $st->fetchColumn();

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
<<<<<<< HEAD
  <h1>POLL #<?php echo($id); ?></h1>
=======
  <h1>USER #<?php echo($id); ?></h1>
>>>>>>> master
</div>
<div class="container">
  <div class="row">
    <table class="table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Description</th>
        <th>Upvotes</th>
        <th>Created</th>
        <th>Author</th>
        <th>Views</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><?php echo($row->id); ?></td>
        <td><?php echo(htmlspecialchars($row->name)); ?></td>
        <td><?php echo(htmlspecialchars($row->description)); ?></td>
        <td><?php echo($row->upvotes); ?></td>
        <td><?php echo(date("d/m/y", $row->created))?></td>
<<<<<<< HEAD
        <?php echo("<td class=\"grey-hover\" onclick=\"document.location = './user?id= " . $row->author . "'\">" . $row->author . "</td>"); ?>
=======
        <td class="grey-hover" onclick="document.location = './user?id= <?php echo($row->author. "'\">" . $row->author);  ?></td>
>>>>>>> master
        <td><?php echo($views); ?></td>
      </tr>
    </tbody>
  </table>
  </div>
  <div class="row actions">
<<<<<<< HEAD
    <div class="col-6">
      <h6 onclick="showAction('edit');" id="btn-action1" class="center cursor full btn btn-primary">Edit</h6>
    </div>
    <div class="col-6">
      <h6 onclick="showAction('delete');" id="btn-action2" class="center cursor full btn btn-primary">Delete</h6>
    </div>
  </div>
  <script>
  var content = "<?php echo(htmlspecialchars($row->description)); ?>";
  var title = "<?php echo(htmlspecialchars($row->name)); ?>";
=======
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
>>>>>>> master
  function showAction(action) {
    $("#" + action)[0].style.display = "block";

    $(".actions")[0].style.display = "none";
  }
<<<<<<< HEAD
  function editText() {
    //Send request to save
    sendRequest("/api/polls/admin_edit", {id: id, title: $("#edit-tile")[0].value, content: $("#edit-content")[0].value}, function(data) {
      //Was the resuest successful
      if (data == "Success") {
        //Send the success notification
        showNotification("Saved changes", "UNDO", function() {
          //If they choose to undo, send undo request
          sendRequest("/api/polls/admin_edit", {id: id, title: title, content: content}, function (data) {
            //Show successful undo
            showNotification("Undid changes");
          });
        });
      }
    });

    $("#edit")[0].style.display = "none";
  }
  </script>
  <form method="post" action="" id="edit" style="display: none;" class="row">
    <label for="edit-title" class="primary">Title</label>
    <input class="form-control btn-primary" id="edit-title" type="text" value="<?php echo(htmlspecialchars($row->name)); ?>">
    <label for="edit-content" class="primary">Content</label>
    <textarea form="delete" id="edit-content" rows="15" class="text form-control" name="content"><?php echo(htmlspecialchars($row->description)); ?></textarea>
    <br>
    <a class="form-control btn btn-primary" type="submit" onclick="editText();">UPDATE POLL</a>
  </form>
=======
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
>>>>>>> master
</div>
