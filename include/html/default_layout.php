<?php namespace Opinionated;

require(__DIR__ . "/html_structure.php");

if (isset($_SESSION["display_name"])) {
  $username = $_SESSION["display_name"];
}

?>
<nav class="navbar navbar-expand-lg navbar-light navbar-fixed-top">
  <div class="container">
      <a class="navbar-brand primary" hidden href="#"> Opinionated NZ</a>
          <i><img class="opinionated-logo" src="/images/opinionated_white_2.png"></i>
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
    </div>
    <?php require(__DIR__ . "/user-dropdown.php"); ?>
</nav>
