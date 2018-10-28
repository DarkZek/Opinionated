<?php namespace Opinionated;

$TITLE = "404 Page Not Found";
require("./include/html/html_structure.php");

?>
<link href="/css/404.css" rel="stylesheet">

<div class="container">
  <h1 class="error">404</h1>
  <h5>Page not found!</h5>
  <a><?php echo($_SERVER["REQUEST_URI"]); ?> is not found on our servers!</a><br>
  <a class="primary" style="cursor: pointer;" onclick="window.history.go(-1);">Click here to go back</a>
</div>
