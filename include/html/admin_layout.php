<?php
require("/var/www/html/include/html/html_structure.php");

if (isset($_SESSION["display_name"])) {
  $username = $_SESSION["display_name"];
}
//Nav bar
?>
<script src="/js/admin.js"></script>
<link href="/css/admin.css" rel="stylesheet">
<script>var xsrf = "<?php if (isset($_SESSION["xsrf_token"])) {echo($_SESSION["xsrf_token"]);} ?>";</script>
<nav class="navbar navbar-expand-lg navbar-light">
  <div class="container">
      <i class="material-icons">build</i>
      <a class="navbar-brand primary" href="#"> Opinionated NZ</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <li class="nav-item active">
            <a class="nav-link" href="/">< Back To Main Site <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item <?php if ($NAV_TAB == "main") {echo ("active");} ?>">
            <a class="nav-link" href="/admin/">Main</a>
          </li>
          <li class="nav-item <?php if ($NAV_TAB == "reports") {echo ("active");} ?>">
            <a class="nav-link" href="/admin/reports">Poll Reports</a>
          </li>
          <li class="nav-item <?php if ($NAV_TAB == "perspective_reports") {echo ("active");} ?>">
            <a class="nav-link" href="/admin/perspective_reports">Perspective Reports</a>
          </li>
          <li class="nav-item <?php if ($NAV_TAB == "database") {echo ("active");} ?>">
            <a class="nav-link" href="/admin/database/">Database</a>
          </li>
          <li class="nav-item dropdown mobile-only active">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
        <li class="nav-item dropdown active ">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
