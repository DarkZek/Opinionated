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
  $q = "SELECT * FROM polls WHERE content LIKE ?;";
  $st = $conn->prepare($q);
  $st->execute(["%" . $_GET["search"] . "%"]);
} else {
  $q = "SELECT * FROM polls ORDER BY upvotes LIMIT 15;";
  $st = $conn->prepare($q);
  $st->execute();
}

?>
<style>
.admin-menu-polls {
  background-color: rgba(0, 0, 0, 0.25) !important;
}
</style>
<div class="center">
  <h1>DATABASE - POLLS</h1>
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
          <th>Title</th>
          <th>Description</th>
          <th>Upvotes</th>
          <th>Created</th>
          <th>Author Id</th>
        </tr>
      </thead>
      <tbody>
        <?php
        while (($row = $st->fetch()) != null) {
            echo('<tr >');
            echo("<td class=\"grey-hover\" onclick=\"document.location = './poll?id=" . $row->id . "'\">" . $row->id . "</td>");
            echo("<td>" . htmlspecialchars($row->name) . "</td>");
            echo("<td>" . htmlspecialchars($row->description) . "</td>");
            echo("<td>" . $row->upvotes . "</td>");
            echo("<td>" . date("d/m/y", $row->created) . "</td>");
            echo("<td class=\"grey-hover\" onclick=\"document.location = './user?id=" . $row->author . "'\">" . $row->author . "</td>");
            echo('<tr>');
        }
        ?>
      </tbody>
    </table>
  </div>
</div>
