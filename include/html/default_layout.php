<?php namespace Opinionated;

require(__DIR__ . "/html_structure.php");

if (isset($_SESSION["display_name"])) {
  $username = $_SESSION["display_name"];
}
<<<<<<< HEAD
=======

?>
>>>>>>> master

?>
<nav class="navbar navbar-expand-lg navbar-light navbar-fixed-top">
  <div class="container">
      <a class="navbar-brand primary" hidden href="#"> Opinionated NZ</a>
          <i><img class="opinionated-logo" src="/images/opinionated_black_2.png"></i>
<<<<<<< HEAD
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
              <li class="nav-item <?php if ($NAV_TAB == "HOME") {echo ("active");} ?>">
                <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item <?php if ($NAV_TAB == "VOTE") {echo ("active");} ?> ">
                <a class="nav-link" href="/vote">Vote for your poll</a>
              </li>
              <li class="nav-item <?php if ($NAV_TAB == "ABOUT") {echo ("active");} ?>">
                <a class="nav-link" href="/about">About Us</a>
              </li>
          </ul>
=======
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <li class="nav-item <?php if ($NAV_TAB == "HOME") {echo ("active");} ?>">
            <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item <?php if ($NAV_TAB == "VOTE") {echo ("active");} ?> ">
            <a class="nav-link" href="/vote">Vote for your poll</a>
          </li>
          <li class="nav-item <?php if ($NAV_TAB == "ABOUT") {echo ("active");} ?>">
            <a class="nav-link" href="/about">About Us</a>
          </li>
          <?php if (isset($username)) { ?>
          <li class="nav-item dropdown mobile-only active">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?php echo($username); ?>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <?php if (isset($_SESSION["rank"]) && $_SESSION["rank"] > 0) { echo("<a class=\"dropdown-item\" href=\"/admin/\">Administration Panel</a>"); } ?>
              <a class="dropdown-item" href="/user">Profile Information</a>
              <a class="dropdown-item" href="/user/settings">Settings</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#" onclick="sendRequest('/api/users/account/logout', {}, function(data) {document.location = '/';} );">Log Out</a>
            </div>
          </li>
          <?php } else {?>
          <li class="nav-item mobile-only active">
            <a class="nav-link" href="/login">Login</a>
          </li>
        <?php } ?>
        </ul>
      </div>
      <ul class="navbar-nav right desktop-only">
        <?php if (isset($username)) { ?>
        <li class="nav-item dropdown active desktop-only">
          <a class="nav-link dropdown-toggle desktop-only" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php echo($username);?>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            <?php if (isset($_SESSION["rank"]) && $_SESSION["rank"] > 0) { echo("<a class=\"dropdown-item\" href=\"/admin/\">Administration Panel</a>"); } ?>
            <a class="dropdown-item" href="/user">Profile Information</a>
            <a class="dropdown-item" href="/user/settings">Settings</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#" onclick="sendRequest('/api/users/account/logout', {}, function(data) {document.location = '/';} );">Log Out</a>
          </div>
        </li>
        <?php } else {?>
        <li class="nav-item active">
          <a class="nav-link" onclick="showDialogue('/api/html/login_page');" style="cursor: pointer;">Login</a>
        </li>
      <?php } ?>
      </ul>
>>>>>>> master
    </div>
    <?php require(__DIR__ . "/user-dropdown.php"); ?>
</nav>
