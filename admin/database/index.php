<?php
//Make sure only admins can access it
require("/var/www/html/include/permissions/admin_only.php");

//
// Setup page settings
//
$TITLE = "Opinionated | Admin Interface";
$NAV_TAB = "database";
require("/var/www/html/include/html/admin_layout.php");
?>
<div class="header">
  <div class="container center">
    <h1>DATABASE ACCESS</h1>
  </div>
</div>
<div class="container">
  <div class="row">
    <div class="col-4">
      <h2>User Accounts</h2>
      <a>Search user accounts and set ranks as well as remove, ban and view perspectives</a>
      <h1 class="btn btn-primary cursor form-control" onclick="document.location = '/admin/database/users';">Access Users</h1>
    </div>
    <div class="col-4">
      <h2>Perspectives</h2>
      <a>Search user perspectives and <b class="primary">admin edit</b> as well as delete, and view statistics</a>
      <h1 class="btn btn-primary cursor form-control" onclick="document.location = '/admin/database/perspectives';">Access Perspectives</h1>
    </div>
    <div class="col-4">
      <h2>Polls</h2>
      <a>Search user polls to delete and edit them and view statistics </a>
      <h1 class="btn btn-primary cursor form-control" onclick="document.location = '/admin/database/polls';">Access Polls</h1>
    </div>
  </div>
</div>
