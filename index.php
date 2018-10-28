<?php namespace Opinionated;
//
// Load page settings
//
$NAV_TAB = "HOME";
$TITLE = "Opinionated | Home";


//
// Include stuff
//
require("./include/show_tutorial.php");
require("./include/sql/sql.php");
require("./include/html/default_layout.php");

//
// Get main poll data
//
$poll_query = "SELECT * FROM main_polls ORDER BY id ASC LIMIT 1;";
$poll_statement = $conn->prepare($poll_query);
$poll_statement->execute();
$poll_data = $poll_statement->fetch();



//
// Check if user has voted in main poll
//
if (isset($_SESSION["id"])) {
  $sql = "SELECT * FROM main_poll_upvotes WHERE user_id = ?;";
  $statement = $conn->prepare($sql);
  $result = $statement->execute([$_SESSION["id"]]);

  if ($statement->rowCount() > 0) {
    //Success! It was an upvote
    $vote = "Up";
  } else {

    //Remove downvotes
    $sql = "SELECT * FROM main_poll_downvotes WHERE user_id = ?;";
    $statement = $conn->prepare($sql);
    $result = $statement->execute([$_SESSION["id"]]);

    if ($statement->rowCount() > 0) {
      $vote = "Down";
    }
  }
}

if (!isset($vote)) {
  $vote = "None";
}

//
// Load main poll perspectives
//
$p_query = "SELECT * FROM main_poll_perspectives JOIN users ON users.id=user_id ORDER BY upvotes LIMIT 15;";
$p_statement = $conn->prepare($p_query);
$p_result = $p_statement->execute();

if ($p_result === True) {
  $perspectives = $p_statement->fetchAll();
}

if (isset($poll_data->upvotes)) { ?>
  <script>
  var upvotes = <?php echo($poll_data->upvotes); ?>;
  var downvotes = <?php echo($poll_data->downvotes); ?>;
  var created = <?php echo($poll_data->created); ?>;
  var vote = "<?php echo($vote); ?>";
  var xsrf = "<?php if (isset($_SESSION["xsrf_token"])) { echo($_SESSION["xsrf_token"]);} ?>";
  </script>
<?php } ?>

<script src="/js/index.js"></script>
<link href="/css/index.css" rel="stylesheet">
<div class="header">
  <div class="container center">
    <h1>NEW ZEALAND MONTHLY POLL</h1>
  </div>
</div>
<br>
<?php if (isset($poll_data->upvotes)) { ?>
<div class="container">
  <h2 class="center"><?php echo($poll_data->name); ?>?</h2>
  <a><?php echo($poll_data->description); ?></a>
</div>
<br>
<div class="mini-container">
  <div class="row center" style="display: flex;">
    <div class="col agree">
      <div class="color">
        <h1 style="color: #8c8c2b;" class="poll-label">YES</h1>
        <h2 style="color: #8c8c2b;"  class="agree-text center">67%</h2>
      </div>
    </div>
    <div class="col disagree">
      <div class="color">
        <h1 style="color: #b62525;" class="poll-label">NO</h1>
        <h2 style="color: #b62525;" class="disagree-text center">67%</h2>
      </div>
    </div>
  </div>
</div>
<br>
<div class="perspectives">
  <h1 class="center">Perspectives</h1>
<?php
//
// Loop through and display perspectives
//
if (isset($perspectives)) {
  foreach($perspectives as $perspective) {


    ?>
    <div class="perspective card container">
      <b id="content left"><i class="material-icons inline">comment</i> <?php echo($perspective->display_name); ?></b>
      <div class="divider"></div>
      <a id="content">"<?php echo($perspective->content); ?>"</a>
      <br>
    </div>
    <?php

  }
}
?>
<br>
<?php
}
?>
</div>
<div class="container">
  <h1 class="center">Sponsors</h1>
  <div class="row">
    <div class="col-4">
      <div class="container sponsor">
        <div class="card">
          <div class="img-contraint" style="background-image: url('/images/placeholders/people.jpg');"></div>
          <div class="container">
            <h6 class="center" href="/sponsors">Your company here</h6>
            <p>Non natus quia recusandae. Dicta architecto nisi dolor non nihil sed qui consequatur. Deserunt maxime molestiae quam ducimus libero. Quaerat et corporis magnam voluptatem qui aliquam.</p>
          </div>
        </div>
      </div>
    </div>
    <div class="col-4">
      <div class="container sponsor">
        <div class="card">
          <div class="img-contraint" style="background-image: url('/images/placeholders/wobweb.jpg');"></div>
          <div class="container">
            <h6 class="center" href="/sponsors">Your company here</h6>
            <p>Non natus quia recusandae. Dicta architecto nisi dolor non nihil sed qui consequatur. Deserunt maxime molestiae quam ducimus libero. Quaerat et corporis magnam voluptatem qui aliquam.</p>
          </div>
        </div>
      </div>
    </div>
    <div class="col-4">
      <div class="container sponsor">
        <div class="card">
          <div class="img-contraint" style="background-image: url('/images/placeholders/server.jpg');"></div>
          <div class="container">
            <h6 class="center" href="/sponsors">Your company here</h6>
            <p>Non natus quia recusandae. Dicta architecto nisi dolor non nihil sed qui consequatur. Deserunt maxime molestiae quam ducimus libero. Quaerat et corporis magnam voluptatem qui aliquam.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <br>
  <br>
  <div class="row">
    <div class="col-4">
      <div class="container sponsor">
        <div class="card">
          <div class="img-contraint" style="background-image: url('/images/placeholders/student.jpg');"></div>
          <div class="container">
            <h6 class="center" href="/sponsors">Your company here</h6>
            <p>Non natus quia recusandae. Dicta architecto nisi dolor non nihil sed qui consequatur. Deserunt maxime molestiae quam ducimus libero. Quaerat et corporis magnam voluptatem qui aliquam.</p>
          </div>
        </div>
      </div>
    </div>
    <div class="col-4">
      <div class="container sponsor">
        <div class="card">
          <div class="img-contraint" style="background-image: url('/images/placeholders/email.png');"></div>
          <div class="container">
            <h6 class="center" href="/sponsors">Your company here</h6>
            <p>Non natus quia recusandae. Dicta architecto nisi dolor non nihil sed qui consequatur. Deserunt maxime molestiae quam ducimus libero. Quaerat et corporis magnam voluptatem qui aliquam.</p>
          </div>
        </div>
      </div>
    </div>
    <div class="col-4">
      <div class="container sponsor">
        <div class="card">
          <div class="img-contraint" style="background-image: url('/images/placeholders/mountains.png');"></div>
          <div class="container">
            <h6 class="center" href="/sponsors">Your company here</h6>
            <p>Non natus quia recusandae. Dicta architecto nisi dolor non nihil sed qui consequatur. Deserunt maxime molestiae quam ducimus libero. Quaerat et corporis magnam voluptatem qui aliquam.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <br>
  <a class="center" href="/sponsors">Click here to learn how to sponsor opinionated</a>
</div>
<br>
<br>
<?php
if (isset($_SESSION["seen_post_register"]) && $_SESSION["seen_post_register"] === "0") {
  require("./include/html/post_register.php");
}
require("./include/html/footer.php");
