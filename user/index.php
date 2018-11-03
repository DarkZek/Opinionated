<?php namespace Opinionated;
//Make sure a user is logged in
require("../include/permissions/user_only.php");

$NAV_TAB = "";
$TITLE = "Have it your way";
require("../include/html/default_layout.php");

?>

<div class="header">
  <div class="container center">
    <h1><?php echo($_SESSION["display_name"]); ?></h1>
  </div>
</div>
