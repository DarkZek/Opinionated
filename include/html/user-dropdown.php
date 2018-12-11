<?php
//
//Login links
//
if (isset($username)) { ?>
  <li class="nav-item dropdown right mobile-only active nav-user-dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <?php echo($username); ?>
    </a>
    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
      <?php if (isset($_SESSION["rank"]) && $_SESSION["rank"] > 0) { echo("<a class=\"dropdown-item\" href=\"/admin/\">Administration Panel</a>"); } ?>
      <a class="dropdown-item" href="/user">Profile Information</a>
      <a class="dropdown-item" href="/user/settings">Settings</a>
      <a class="dropdown-item cursor" onclick="setDarkTheme(!darkTheme);">Dark Theme</a>
      <div class="dropdown-divider"></div>
      <a class="dropdown-item" href="#" onclick="sendRequest('/api/users/account/logout', {}, function(data) {document.location = '/';} );">Log Out</a>
    </div>
  </li>



<?php
//
// Mobile login link
//
} else { ?>
<li class="nav-item mobile-only right active">
  <a class="nav-link" href="/login">Login</a>
</li>
<?php } ?>



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
    <a class="dropdown-item cursor" onclick="setDarkTheme(!darkTheme);">Dark Theme</a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="#" onclick="sendRequest('/api/users/account/logout', {}, function(data) {document.location = '/';} );">Log Out</a>
  </div>
</li>
<?php } else {?>
<li class="nav-item active right">
<a class="nav-link" onclick="showDialogue('/api/html/login_page');" style="cursor: pointer;">Login</a>
</li>
<?php } ?>
