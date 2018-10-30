<?php namespace Opinionated;

require(__DIR__ . "/html_structure.php");

if (isset($_SESSION["display_name"])) {
  $username = $_SESSION["display_name"];
}

//Nav bar
?>
<script src="/js/admin.js"></script>
<link href="/css/admin.css" rel="stylesheet">
<script>var xsrf = "<?php if (isset($_SESSION["xsrf_token"])) {echo($_SESSION["xsrf_token"]);} ?>";</script>
<nav class="navbar navbar-expand-lg navbar-light b-primary">
  <div class="col-2">
    <img class="opinionated-logo" src="/images/opinionated_black_2.png">
  </div>
  <div class="col-3 search">
    <i class="material-icons">search</i>
    <input type="text" placeholder="Search User">
  </div>
  <div class="col-3">
  </div>
  <div class="col-2 notifications">
    <i class="material-icons"><a class="notification-icon">40</a>supervisor_account</i>
  </div>
  <div class="col-2">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav ">
          <li class="nav-item dropdown mobile-only">
            <a class="nav-link dropdown-toggle white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?php echo($username);?>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <?php if (isset($_SESSION["rank"]) && $_SESSION["rank"] > 0) { echo("<a class=\"dropdown-item\" href=\"/admin/\">Administration Panel</a>"); } ?>
              <a class="dropdown-item" href="#">Profile Information</a>
              <a class="dropdown-item" href="#">Settings</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">Log Out</a>
            </div>
          </li>
        </ul>
      </div>
      <ul class="navbar-nav right desktop-only">
        <li class="nav-item dropdown ">
          <a class="nav-link dropdown-toggle white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php echo($username);?>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            <?php if (isset($_SESSION["rank"]) && $_SESSION["rank"] > 0) { echo("<a class=\"dropdown-item\" href=\"/admin/\">Administration Panel</a>"); } ?>
            <a class="dropdown-item" href="/user">Profile Information</a>
            <a class="dropdown-item" href="/user/settings">Settings</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#" onclick="$('#logout')[0].submit();">Log Out</a>
            <form id="logout" action="/api/logout" method="POST"><input hidden value="<?php echo($_SESSION["xsrf_token"]); ?>" type="text" name="xsrf"></form>
          </div>
        </li>
      </ul>
  </div>
</nav>
<div class="sidebar row">
  <div class="col-2 b-primary">
    <div class="row menu-item selected" onclick="">
      <a>Dashboard</a>
    </div>
  </div>
  <div class="col-10">
