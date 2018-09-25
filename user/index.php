<?php
//Make sure a user is logged in
require("/var/www/html/include/permissions/user_only.php");

$NAV_TAB = "";
$TITLE = "Have it your way";
require("/var/www/html/include/html/default_layout.php");

?>

<div class="header">
  <div class="container center">
    <h1><?php echo($_SESSION["display_name"]); ?></h1>
  </div>
</div>
