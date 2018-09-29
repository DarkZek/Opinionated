<?php
//Make sure only admins can access it
require("/var/www/html/include/permissions/admin_only.php");
require("/var/www/html/include/sql/sql.php");


if (!isset($_GET["id"])) {
  header("Location: ./users");
}


//
// Setup page settings
//
$TITLE = "Opinionated | Admin Interface";
$NAV_TAB = "database";
include("/var/www/html/include/html/admin_layout.php");

$id = $_GET["id"];

$q = "SELECT * FROM users WHERE id = ?;";
$st = $conn->prepare($q);
$st->execute([$id]);

$row = $st->fetch();

?>
<div class="header">
  <div class="container center">
    <h1>USER #<?php echo($id); ?></h1>
  </div>
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
      </tr>
    </tbody>
  </table>
  </div>
</div>
