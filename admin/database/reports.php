<?php namespace Opinionated;
//Make sure only admins can access it
require("../../include/permissions/admin_only.php");



$TITLE = "Admin Interface";
$NAV_TAB = "reports";
require("../../include/html/admin_layout.php");

//Load MySQL connection
require("../../include/sql/sql.php");

?>
<style>
.admin-menu-reports {
  background-color: rgba(0, 0, 0, 0.25) !important;
}
</style>
<div class="container">
  <h1 class="center">POLL REPORTS</h1>
  <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Post name</th>
      <th scope="col">Report Reason</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>

    <?php
    //
    //Get 10 reports
    //
    $query = "SELECT * FROM poll_reports JOIN polls ON poll_reports.poll_id=polls.id WHERE poll_reports.id BETWEEN 0 AND 10";
    $statement = $conn->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();




    //Function to get name of post
    function getName($conn, $id) {
      //Get 10 posts
      $query = "SELECT * FROM polls WHERE id = ?";
      $statement = $conn->prepare($query);
      $statement->execute([$id]);
      return $statement->fetchAll()[0]->name;
    }

    //Function to convert report reason to string
    function reportIDToString($id) {
      switch ($id) {
        case 1: {
          return "Its not a poll";
        }
        case 2: {
          return "Poll is biased";
        }
        case 3: {
          return "Poll is unnecessarily offensive";
        }
        case 4: {
          return "Malicious Links";
        }
      }

      return "Unknown report reason";
    }

    //Loop through polls
    $number = 0;
    while (count($result) > $number) {
      $row = $result[$number];
      ?>
    <tr>
      <th scope="row"><?php echo($row->id); ?></th>
      <td><?php echo(getName($conn, $row->poll_id)); ?></td>
      <td><?php echo(reportIDToString($row->reason)); ?></td>
      <td>
        <button onclick="deleteFunction(this, '<?php echo($row->id); ?>', '<?php echo($row->reason); ?>');" class="inline btn-primary btn">DELETE</button>
        <button onclick="dismissFunction(this, '<?php echo($row->id); ?>');" class="inline btn-secondary btn">DISMISS</button>
        <button onclick="blockFunction(this, '<?php echo($row->id); ?>', '<?php echo($row->user_id); ?>');" class="inline btn-primary btn">BLOCK USER</button>
      </td>
    </tr>
    <td colspan="4"><?php echo($row->description); ?></td><br><br>
  <?php $number = $number + 1;
    } ?>
  </tbody>
</table>
</div>

<script>
function deleteFunction(object, id, reason) {
  sendRequest('/api/polls/remove', { id: id, reason: reason});
  sendRequest('/api/polls/reports/delete', { id: id});
  object.parentNode.parentNode.style.display = 'none';
  object.parentNode.parentNode.nextElementSibling.style.display = 'none';
}
function blockFunction(object, id, user_id) {
  sendRequest('/api/users/block_reports', { id: id});
  sendRequest('/api/polls/reports/delete', { id: id});
  object.parentNode.parentNode.style.display = 'none';
  object.parentNode.parentNode.nextElementSibling.style.display = 'none';
}
function dismissFunction(object, id) {
  sendRequest('/api/polls/reports/delete', { id: id});
  object.parentNode.parentNode.style.display = 'none';
  object.parentNode.parentNode.nextElementSibling.style.display = 'none';
}
</script>
