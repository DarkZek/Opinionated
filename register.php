<?php
$TITLE = "Opinionated | Register";
$HEAD = "<script src='https://www.google.com/recaptcha/api.js'></script>";
include("/var/www/html/include/html_structure.php");

include("/var/www/html/include/nz_only.php");

require("/var/www/html/include/register_page.php");

?>
<script>
$(".master")[0].style.opacity = 1;
$(".master")[0].style.top = 10;
</script>
