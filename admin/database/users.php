<?php namespace Opinionated;
//Make sure only admins can access it
require("../../include/permissions/admin_only.php");
require("../../include/sql/sql.php");


//
// Setup page settings
//
$TITLE = "Opinionated | Admin Interface";
$NAV_TAB = "database";
include("../../include/html/admin_layout.php");


if ($_GET["search"] === "") {
  unset($_GET["search"]);
}

//
//Load perspectives
//
if (isset($_GET["search"])) {
  $q = "SELECT * FROM users WHERE display_name LIKE ? OR username LIKE ? OR email LIKE ? LIMIT 15;";
  $st = $conn->prepare($q);
  $search_q = "%" . $_GET["search"] . "%";
  $st->execute([$search_q,$search_q,$search_q]);
} else {
  $q = "SELECT * FROM users ORDER BY display_name LIMIT 15;";
  $st = $conn->prepare($q);
  $st->execute();
}

?>
<style>
.admin-menu-users {
  background-color: rgba(0, 0, 0, 0.25) !important;
}
</style>
<div class="center">
  <h1>DATABASE - USERS</h1>
</div>
<br>
<div class="container">
  <form method="GET" class="row">
    <div class="col-10">
      <input type="text" name="search" <?php if(isset($_GET["search"])) { echo("value=\"" . $_GET["search"] . "\""); } ?> placeholder="Search User" class="form-control">
    </div>
    <div class="col-2">
        <input type="submit" value="Search" class="btn-primary form-control">
    </div>
  </form>
  <div class="row">
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Username</th>
          <th>Display Name</th>
          <th>Email Address</th>
          <th>account_type</th>
        </tr>
      </thead>
      <tbody>
        <?php
        while (($row = $st->fetch()) != null) {
            echo('<tr');
            if ($row->banned == "1") {
              echo(" style='background-color: #fbe5ef;' ");
            }
            echo(">");
            echo("<td class=\"grey-hover\" onclick=\"document.location = './user?id=" . $row->id . "'\">" . $row->id . "</td>");
            echo("<td>" . htmlspecialchars($row->username) . "</td>");
            echo("<td>" . htmlspecialchars($row->display_name) . "</td>");
            echo("<td>" . htmlspecialchars($row->email) . "</td>");
            echo("<td>" . htmlspecialchars($row->account_type) . "</td>");
            echo('<tr>');
        }
        ?>
      </tbody>
    </table>
  </div>
</div>
