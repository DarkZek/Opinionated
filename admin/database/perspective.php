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

$q = "SELECT * FROM poll_perspectives WHERE id = ?;";
$st = $conn->prepare($q);
$st->execute([$id]);

$row = $st->fetch();

?>
<div class="header">
  <div class="container center">
    <h1>PERSPECTIVE #<?php echo($id); ?></h1>
  </div>
</div>
<div class="container">
  <div class="row">
    <table class="table">
    <thead>
      <tr>
        <th>Upvotes</th>
        <th>Created</th>
        <th>User</th>
        <th>Content</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><?php echo($row->upvotes) ?></td>
        <td><?php echo($row->created) ?></td>
        <td <?php echo("class=\"grey-hover\" onclick=\"document.location = './user?id=" . $row->user_id . "'\">" . $row->user_id); ?> </td>
        <td><?php echo($row->content) ?></td>
      </tr>
    </tbody>
  </table>
  </div>
  <div class="row">
    <h6 onclick="showDelete(this);" class="center cursor full btn btn-primary">Remove Perspective</h6>
  </div>
  <script>
  function showDelete(button) {
    $("#delete")[0].style.display = "block";
    button.classList.remove("btn");
    button.classList.remove("btn-primary");
    button.classList.remove("cursor");
  }
  </script>
  <form method="post" action="/api/polls/perspectives/remove" id="delete" id="delete-reason" style="display: none;" class="row">
    <input name="xsrf" hidden value="<?php echo($_SESSION["xsrf_token"]); ?>">
    <input name="id" hidden value="<?php echo($id); ?>">
    <label for="delete-reason" class="primary">Message</label>
    <textarea form="delete" rows="15" class="text form-control" name="reason">Unfortunately your perspective was removed!
The perspective:
<?php echo($row->content); ?>


We've found it to be breaking some of our rules.
  - RULE
Please take care to read our rules at https://opinionated.nz/perspectives#rules as multiple rule violations could lead to your ability to submit perspectives being revoked
- The Opinionated Team</textarea>
    <br>
    <input class="form-control btn-primary" type="submit" value="REMOVE PERSPECTIVE">
  </form>
</div>
