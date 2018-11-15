<?php namespace Opinionated;

if (!isset($_SESSION)) {
  session_start();
}

//Check if they're overseas
if (!isset($_SESSION["from_nz"])) {
  require(__DIR__ . "/../geo/check_if_nz.php");
}

//Check if they're overseas
if (isset($_SESSION["verified"]) && $_SESSION["verified"] === False) {
  header("Location: /user/verify_email");
  die();
}

?>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta charset="UTF-8">
  <link href="/css/bootstrap.min.css" rel="stylesheet">
  <script src="/js/jquery.min.js"></script>
  <script src="/js/bootstrap.min.js"></script>
  <script src="/js/main.js"></script>
  <link href="/css/main.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"><link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/brands.css" integrity="sha384-7xAnn7Zm3QC1jFjVc1A6v/toepoG3JXboQYzbM0jrPzou9OFXm/fY6Z/XiIebl/k" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/fontawesome.css" integrity="sha384-ozJwkrqb90Oa3ZNb+yKFW2lToAWYdTiF1vt8JiH5ptTGHTGcN7qdoR1F95e0kYyG" crossorigin="anonymous">
  <title><?php echo($TITLE); ?></title>
  <script>var xsrf = "<?php if (isset($_SESSION["xsrf_token"])) { echo($_SESSION["xsrf_token"]);} ?>";</script>
  <?php
  if (isset($HEAD)) {
     echo ($HEAD);
  } ?>
</head>

<?php

//Show errors
if (isset($_SESSION["error"])) {
  $error = $_SESSION["error"];
  ?>
  <div class="error-modal shadow animated rounded">
    <h4><?php echo($error); ?></h4>
  </div>
  <script>
  $(document).ready(function() {
    setTimeout(function(){
      $(".error-modal")[0].classList.add("anim-fadeOut");
      hideObject(".error-modal");
    }, 5000);
  });
  </script>
  <?php
  unset($_SESSION["error"]);
}
//Show info
if (isset($_SESSION["info"])) {
  $info = $_SESSION["info"];
  ?>
  <div class="info-modal animated anim-fadeOut shadow rounded">
    <h4><?php echo($info); ?></h4>
  </div>
  <script>
  $(document).ready(function() {
    hideObject($(".info-modal"));
  });
  </script>
  <?php
  unset($_SESSION["info"]);
}

if ($_SESSION["from_nz"] == False) {
  ?>
  <div class="top-bar">
    <div class="container">
      <a class="center">Opinionated is in READ ONLY mode. Only people located in New Zealand can participate in Opinionated!</a>
    </div>
  </div>
  <?php
}
?>
