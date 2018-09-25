<?php

if (isset($_POST["xsrf"])) {
  $xsrf = $_POST["xsrf"];
}

if (isset($_GET["xsrf"])) {
  $xsrf = $_GET["xsrf"];
}

if (!isset($xsrf)) {
  die("[ERROR] Incorrect XSRF token");
}

if ($_SESSION["xsrf_token"] !== $xsrf) {
  die("[ERROR] Incorrect XSRF token");
}
