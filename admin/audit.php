<?php namespace Opinionated;
//Make sure only admins can access it
require("/var/www/html/include/permissions/admin_only.php");
require("/var/www/html/include/permissions/AuditFormatter.php");


//
// Setup page settings
//
$TITLE = "Opinionated | Admin Interface";
$NAV_TAB = "main";
require("/var/www/html/include/html/admin_layout.php");
require("/var/www/html/include/sql/sql.php");


//
// Get sponsor spots
//
$q = "SELECT * FROM sponsor_spots LIMIT 6;";
$st = $conn->prepare($q);
$st->execute();
$sponsors = $st->fetchAll();

?>
<script src="/js/sponsors.js"></script>
<style>
.scrollable {
  overflow-y: scroll;
  height: 100%;
  overflow-x: hidden;
}
.admin-menu-audit {
  background-color: rgba(0, 0, 0, 0.25) !important;
}
</style>
<div class="container">
  <h1 class="center">AUDIT LOG</h1>
  <table class="table">
  <tbody>

    <?php
    //
    //Get 10 reports
    //
    $query = "SELECT * FROM audit_log WHERE id BETWEEN 0 AND 20";
    $statement = $conn->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();


    //Loop through polls
    $number = 0;
    while (count($result) > $number) {
      $row = $result[$number];
      ?>
    <tr>
      <td><?php echo(AuditFormatter::Format($row)); ?></a></td>
    </tr>
  <?php $number = $number + 1;
    } ?>
  </tbody>
</table>
</div>
