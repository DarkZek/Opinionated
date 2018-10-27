<?php

require_once(__DIR__ . "/../../vendor/autoload.php");

?>
<div onclick="hideDialogue(this);" class="anim-fast animated anim-fadeIn grey-out"></div>
<div class="dialogue master animated anim-slideDown container anim-fast">
  <div class="card shadow-sm dialogue-card" style="z-index: 2;">
    <div class="header">
      <div class="row">
        <h1 class="center white"><?php echo($title); ?></h1>
        <h2 class="white exit" onclick="hideDialogue($('.grey-out')[0]);">x</h2>
      </div>
    </div>
    <div class="content container">
      <?php require($content); ?>
    </div>
  </div>
</div>
