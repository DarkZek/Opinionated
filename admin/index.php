<?php namespace Opinionated;
//Make sure only admins can access it
require("/var/www/html/include/permissions/admin_only.php");


//
// Setup page settings
//
$TITLE = "Opinionated | Admin Interface";
$NAV_TAB = "main";
require("/var/www/html/include/html/admin_layout.php");
require("/var/www/html/include/sql/sql.php");


//
//Get leading poll
//
$q = "SELECT * FROM polls ORDER BY upvotes DESC LIMIT 1;";
$st = $conn->prepare($q);
$st->execute();
$top_poll = $st->fetch()->name;


//
//Get user count
//
$q = "SELECT COUNT(*) FROM users;";
$st = $conn->prepare($q);
$st->execute();
$user_count = $st->fetchColumn();


//
//Get poll count
//
$q = "SELECT COUNT(*) FROM polls;";
$st = $conn->prepare($q);
$st->execute();
$poll_count = $st->fetchColumn();

?>
<style>
.admin-menu-dashboard {
  background-color: rgba(0, 0, 0, 0.25) !important;
}
</style>
<div>
  <div class="row">
    <div class="col-4">
      <div class="card center dashboard-stat">
        <h2 style="margin-top: 10px;">Current Leading Poll</h2>
        <a><?php echo($top_poll); ?></a>
      </div>
      <div class="card cursor" hidden onclick="document.location = '/api/main_poll/update.php';">
        <a>UPDATE MAIN POLL</a>
      </div>
    </div>
    <div class="col-4">
      <div class="card center dashboard-stat cursor" onclick="document.location = '/admin/database/user';">
        <br>
        <h2><?php echo($user_count); ?> Users</h2>
      </div>
    </div>
    <div class="col-4">
      <div class="card center dashboard-stat">
        <br>
        <h2><?php echo($poll_count); ?> Polls</h2>
      </div>
    </div>
  </div>
  <br>
  <div class="row">
    <canvas id="myChart" width="400" height="125px"></canvas>
    <script>
    var ctx = document.getElementById("myChart").getContext('2d');
    var myChart = new Chart(ctx, {
    type: 'line',
      data: {
        labels: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
        datasets: [{
            label: 'Number of unique visits per day',
            data: [5, 6, 3, 5, 2, 15, 21],
            fill: true,
            backgroundColor: "rgba(87, 191, 55, 0.3)",
            borderColor: "rgba(87, 191, 55, 0.6)"

        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>
  </div>
</div>
