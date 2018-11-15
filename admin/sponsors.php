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
<style>
.sponsor {
  background-color: #e4e4e4;
  padding: 20px;
  padding-bottom: 5px;
  padding-top: 5px;
}
.scrollable {
  overflow-y: scroll;
  height: 100%;
  overflow-x: hidden;
}
</style>
<div class="">
  <?php
  for ($i = 0; $i < 6; $i += 1) {
    $sponsor = $sponsors[$i];
    ?>
    <div>
      <h2 class="cursor sponsor rounded" data-toggle="collapse" data-target="#spot<?php echo($i); ?>">Sponsor Spot #<?php echo($i); ?></h2>
      <div id="spot<?php echo($i); ?>" class="collapse <?php if ($i === 0) {echo("show"); } ?>">
        <div class="row">
          <div class="col-2">
            <img src="<?php echo($sponsor->image_url); ?>" style="width: 100%;">
          </div>
          <div class="col-10">
            <label class="primary" for="sponsor<?php echo($i); ?>message">Sponsor Message:</label>
            <textarea class="form-control" id="sponsor<?php echo($i); ?>message"><?php echo($sponsor->message); ?></textarea>
            <label class="primary" for="sponsor<?php echo($i); ?>image">Sponsor Image URL</label>
            <input type="text" class="form-control" id="sponsor1image" value="<?php echo($sponsor->image_url); ?>">
          </div>
        </div>
      </div>
    </div>
    <br>
    <?php
  }
  ?>
</div>
