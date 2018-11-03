<?php namespace Opinionated;
//Make sure only admins can access it
require("../../include/permissions/admin_only.php");
require("../../include/sql/sql.php");
<<<<<<< HEAD
=======
require("../../include/run/Runner.php");
>>>>>>> master


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
  $q = "SELECT * FROM poll_perspectives WHERE content LIKE ?;";
  $st = $conn->prepare($q);
  $st->execute(["%" . $_GET["search"] . "%"]);
} else {
  $q = "SELECT * FROM poll_perspectives ORDER BY upvotes LIMIT 15;";
  $st = $conn->prepare($q);
  $st->execute();
}

?>
<div class="center">
  <h1>DATABASE - PERSPECTIVES</h1>
</div>
<br>
<div class="container">
  <form method="GET" class="row">
    <div class="col-10">
      <input type="text" name="search" <?php if(isset($_GET["search"])) { echo("value=\"" . $_GET["search"] . "\""); } ?> placeholder="Search Content" class="form-control">
    </div>
    <div class="col-2">
        <input type="submit" placeholder="Search" class="b-primary form-control">
    </div>
  </form>
  <div class="row">
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Upvotes</th>
          <th>Created</th>
          <th>User</th>
          <th>Content</th>
        </tr>
      </thead>
      <tbody>
        <?php
        while (($row = $st->fetch()) != null) {
            echo('<tr >');
            echo("<td class=\"grey-hover\" onclick=\"document.location = './perspective?id=" . $row->id . "'\">" . $row->id . "</td>");
            echo("<td>" . $row->upvotes . "</td>");
            echo("<td>" . date("d/m/y", $row->created) . "</td>");
            echo("<td class=\"grey-hover\" onclick=\"document.location = './user?id=" . $row->user_id . "'\">" . $row->user_id . "</td>");
            echo("<td>" . htmlspecialchars($row->content) . "</td>");
            echo('<tr>');
        }
        ?>
      </tbody>
    </table>
  </div>
</div>
