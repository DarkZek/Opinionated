<?php

require_once(__DIR__ . "/../../vendor/autoload.php");

?>
<div <?php if (!$settings->force) {echo('onclick="hideDialogue(this);"'); } ?> class="anim-fast animated anim-fadeIn grey-out"></div>
<div class="dialogue master animated anim-slideDown container anim-fast" style="<?php if (isset($settings->style)) {echo($settings->style); } ?>">
  <div class="card shadow-sm dialogue-card" style="z-index: 2; border-radius: 5px 5px 0px 0px;">
    <div class="header">
      <div class="row">
        <h1 class="center white"><?php echo($title); ?></h1>
        <?php if (!$settings->force) { ?>
          <div class="exit-circle">
            <h2 class="white exit" onclick="hideDialogue($('.grey-out')[0]);">x</h2>
          </div>
        <?php } ?>
      </div>
    </div>
    <div class="content container">
      <?php require($content); ?>
    </div>
  </div>
  <script>
  //TODO: Fix this taking two esc presses to hide
  $(document).keydown(function(e) {
     if (e.key === "Escape") {
        hideDialogue($('.grey-out')[0]);
    }
  });
  </script>
</div>
