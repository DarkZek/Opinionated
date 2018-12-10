<?php namespace Opinionated;
//Make sure only admins can access it
require("/var/www/html/include/permissions/admin_only.php");


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
.sponsor {
  background-color: rgba(0, 0, 0, 0.1);
  padding: 20px;
  padding-bottom: 5px;
  padding-top: 5px;
}
.scrollable {
  overflow-y: scroll;
  height: 100%;
  overflow-x: hidden;
}
.admin-menu-sponsors {
  background-color: rgba(0, 0, 0, 0.25) !important;
}
.down_arrow {
  margin-top: 10px;
  margin-right: 10px;
}
</style>
<div class="">
  <?php
  for ($i = 0; $i < 6; $i += 1) {
    $sponsor = $sponsors[$i];
    ?>
    <div>
      <div class="sponsor row">
        <div class="col-8">
          <div class="row cursor" data-toggle="collapse" data-target="#spot<?php echo($i); ?>">
            <i class="material-icons down_arrow">keyboard_arrow_down</i>
            <h2>Sponsor Spot #<?php echo($i); ?></h2>
          </div>
        </div>
        <div class="col-4">
          <a class="btn btn-primary white right" onclick="saveChanges(<?php echo($i); ?>);" id="apply<?php echo($i); ?>" style="margin-top: 5px;display: none;">APPLY CHANGES</a>
        </div>
      </div>
      <br>
      <div id="spot<?php echo($i); ?>" class="collapse <?php if ($i === 0) {echo("show"); } ?>">
        <div class="row">
          <div class="col-2">
            <img id="image<?php echo($i); ?>" style="width: 100%;">
          </div>
          <div class="col-10">
            <label for="sponsor<?php echo($i); ?>title">Sponsor Title</label>
            <input type="text" class="form-control" onkeydown="dataChanged(<?php echo($i); ?>);" id="sponsor<?php echo($i); ?>title" value="<?php echo(htmlspecialchars($sponsor->title)); ?>">
            <label for="sponsor<?php echo($i); ?>message">Sponsor Message:</label>
<<<<<<< HEAD
            <textarea class="form-control" maxlength="200" onkeydown="dataChanged(<?php echo($i); ?>);" id="sponsor<?php echo($i); ?>message"><?php echo(htmlspecialchars($sponsor->message)); ?></textarea>
=======
            <textarea class="form-control" onkeydown="dataChanged(<?php echo($i); ?>);" id="sponsor<?php echo($i); ?>message"><?php echo(htmlspecialchars($sponsor->message)); ?></textarea>
>>>>>>> master
            <label for="sponsor<?php echo($i); ?>image">Sponsor Image URL</label>
            <input type="text" class="form-control" onkeyup="imageChanged(<?php echo($i); ?>);" id="sponsor<?php echo($i); ?>image" value="<?php echo(htmlspecialchars($sponsor->image_url)); ?>">
          </div>
        </div>
      </div>
    </div>
    <br>
    <?php
  }
  ?>
</div>
