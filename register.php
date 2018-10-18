<?php namespace Opinionated;
$TITLE = "Opinionated | Register";
$HEAD = "<script src='https://www.google.com/recaptcha/api.js'></script>";

//Include html data
require("./include/html/html_structure.php");
//New zealanders only
require("./include/geo/nz_only.php");
//Load register page
require("./include/html/register_page.php");

?>
<script>
$(".master")[0].style.opacity = 1;
$(".master")[0].style.top = 10;
</script>
