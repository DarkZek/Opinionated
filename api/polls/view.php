<?php

//TODO: Convert to DateTime::createFromFormat('d. m. Y', $raw)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION["id"])) {
  $user_id = $_SESSION["id"];
}

//Load MySQL connection
require(__DIR__ . "/../../include/sql/sql.php");

if (isset($_GET["id"])) {
  $poll_id = $_GET["id"];
}


//
//Get the page number
//
if (!isset($_GET["page"])) {
  $page = 0;
} else {
  try {
    if (is_numeric($_GET["page"])) {
      $page = (int) $_GET["page"];
    } else {
      $page = 0;
    }
  } catch (Exception $e) {
    die("[ERROR] Invald page number");
  }
}


if (isset($_SESSION["id"])) {
  //If they already have a post Id they want to view
  if (isset($poll_id)) {
    //Select that post ID if they have not already upvoted it
    $query = "SELECT * FROM polls WHERE id NOT IN (SELECT poll_id FROM poll_upvotes WHERE user_id = ?) AND id NOT IN (SELECT poll_id FROM poll_skips WHERE user_id = ?) AND id = ? ORDER by upvotes DESC LIMIT 1;";
    $statement = $conn->prepare($query);
    $statement->execute([$_SESSION["id"], $_SESSION["id"], $poll_id]);
    $result = $statement->fetchAll();
  }
  //If the previous if statement wasnt ran or returned nothing (they already upvoted the post)
  if ((isset($statement) && (count($result) == 0)) || !isset($poll_id)) {
    //Get the top post they have not upvoted,
    $query = "SELECT * FROM polls WHERE id NOT IN (SELECT poll_id FROM poll_upvotes WHERE user_id = ?) AND id NOT IN (SELECT poll_id FROM poll_skips WHERE user_id = ?) ORDER by upvotes DESC LIMIT 1;";
    $statement = $conn->prepare($query);
    $statement->execute([$_SESSION["id"], $_SESSION["id"]]);
    $result = $statement->fetchAll();
  }

} else {
  if (isset($poll_id)) {
    //Create sql query
    $query = "SELECT * FROM polls WHERE id = ?;";
    $statement = $conn->prepare($query);
    $statement->execute([$poll_id]);
    $result = $statement->fetchAll();
  } else {
    //Create sql query
    $query = "SELECT * FROM polls ORDER BY upvotes LIMIT 1;";
    $statement = $conn->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
  }
}

if (count($result) == 0) {
  require(__DIR__ . "/../../include/html/no_polls.php");
  die();
}

$row = $result[0];

//Get perspectives
$p_query = "SELECT poll_perspectives.created,poll_id,display_name,upvotes,content FROM poll_perspectives JOIN users ON users.id=user_id WHERE poll_id = ? LIMIT 15;";
$p_statement = $conn->prepare($p_query);
$p_statement->execute([$row->id]);
$p_results = $p_statement->fetchAll();

//Return the posts in HTML
?>
<div class="perspective-container animated anim-slideLeftIn" style="overflow: hidden; display: block;">
<div id="title-prefab" style="display: block;">
    <br class="desktop-only">
    <br>
    <div class="container">
      <h1 class="center" id="title">
        <i class="material-icons report-button" onclick="currentReportId = <?php echo($row->id); ?>; showDialogue('/api/html/report_poll');">report</i>
      <?php echo(htmlspecialchars($row->name)); ?></h1>
    </div>
    <h5 class="center" id="date"></h5>
    <div class="container">
        <a class="center" name="description" id="description"><?php echo(htmlspecialchars($row->description)); ?></a>
    </div>
    <br>
    <br>
  </div><form action="/api/polls/perspectives/submit" method="POST" style="display: block;" id="" class="your-perspective vote">
    <div class="container">
      <br>
      <div class="row">
        <a class="center yes-vote btn" style="width: 100%;">Whats your perspective?</a>
      </div>
      <br>
      <div class="row">
        <div class="form-group" style="width: 100%;">
          <textarea minlength="50" maxlength="498" name="content" class="form-control" onchange="onType(this);" style="width: 100%;" rows="5" id="comment"></textarea>
          <input name="xsrf" id="xsrf" value="" type="text" hidden="">
          <input name="poll_id" id="poll_id" value="" type="text" hidden="">
          <a style="color: gray">(50) min       (500) max</a>
        </div>
      </div>
      <div class="row">
        <input type="submit" class="center no-vote btn" onclick="return perspectiveFilledOut(this);" style="width: 100%;" value="SUBMIT PERSPECTIVE">
      </div>
      <br>
    </div>
  </form><div style="display: block;" id="" class="container vote">
    <div class="row">
      <div class="col-6">
        <a class="center yes-vote btn" onclick="if (UpvotePost($('#id')[0].textContent)) {LoadNewPoll();}" style="width: 100%;">LETS VOTE</a>
      </div>
      <div class="col-6">
        <a class="center no-vote btn" onclick="LoadNewPoll();" style="width: 100%;">NEXT POLL</a>
      </div>
    </div>
    <br>
  </div>
  <a>
  <?php
  for ($number = 0; $number < count($p_results); $number++) {
    $perspective = $p_results[$number];
    ?>
    {
      "author": "<?php echo(htmlspecialchars($perspective->display_name)); ?>",
      "content": "<?php echo(htmlspecialchars($perspective->content)); ?>"
    }
    <?php
    if ($number < (count($p_results) - 1)) {
      echo(",");
    }
  }?>
</a>
</div>
