<?php namespace Opinionated;

//Make sure only admins can access it
require("../../include/permissions/admin_only.php");

if (!isset($_POST["confirm"]) || !isset($_POST["xsrf"])) {

  ?>
  <h1>Are you sure you want to continue?</h1>
  <a>Type "confirm" to confirm</a>
  <form action="" method="POST">
    <input name="confirm">
    <input hidden name="xsrf" value="<?php echo($_SESSION["xsrf_token"]); ?>">
    <br>
    <input type="submit" value="SUBMIT ">
  </form>
  <?php
  die();
}

require("/var/www/html/include/permissions/check_xsrf.php");
if ($_POST["confirm"] !== "confirm") {
  die("Not confirmed");
}


//Connect to sql server
require("/var/www/html/include/sql/sql.php");


//
// Find the highest upvoted poll
//
echo("Finding new poll...<br><br>");
$poll_query = "SELECT * FROM polls ORDER BY upvotes DESC LIMIT 1;";
$poll_statement = $conn->prepare($poll_query);
$poll_statement->execute();
$poll = $poll_statement->fetch();
echo("Found: " . $poll->name . "<br><br>");


//
// Delete old upvotes on main poll
//
echo("Deleting old upvotes and downvotes...");
$conn->prepare("TRUNCATE TABLE main_poll_upvotes;")->execute();
$conn->prepare("TRUNCATE TABLE main_poll_downvotes;")->execute();


//
// Delete old perspectives on main poll
//
echo("Deleting old perspectives ...");
$conn->prepare("TRUNCATE TABLE main_poll_perspectives;")->execute();
echo("Deleted old upvotes...");


//
// Add new poll to database
//
echo("Inserting into database...<br><br>");
$insert_new_query = "INSERT INTO main_polls (name, description, upvotes, downvotes, created, author) VALUES (?,?,?,?,?,?);";
$insert_new_statement = $conn->prepare($insert_new_query);
$insert_new_statement->execute([$poll->name, $poll->description, 0, 0, $poll->created, $poll->author]);
echo("Inserted!<br><br>");


//
// Delete new main poll from poll ideas page
//
echo("Deleting new poll from poll ideas database...");
$delete_query = "DELETE FROM polls WHERE id = ?;";
$delete_statement = $conn->prepare($delete_query);
$delete_statement->execute($poll->id);
echo("Successfully changed poll...<br><br>");


//
// Redirect
//
?>
<script>
setTimeout(function () {
  document.location = "/";
}, 2000);
</script>
