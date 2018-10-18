<?php

//TODO: Convert to DateTime::createFromFormat('d. m. Y', $raw)

session_start();

if (isset($_SESSION["id"])) {
  $user_id = $_SESSION["id"];
}

//Load MySQL connection
require("../../include/sql/sql.php");

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

  //
  //
  //

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
  die("None");
}

$row = $result[0];

//Get perspectives
$p_query = "SELECT poll_perspectives.created,poll_id,display_name,upvotes,content FROM poll_perspectives JOIN users ON users.id=user_id WHERE poll_id = ? LIMIT 15;";

$p_statement = $conn->prepare($p_query);

$p_statement->execute([$row->id]);

$p_results = $p_statement->fetchAll();

//Return the posts in JSON
?>{
  "name": "<?php echo(htmlspecialchars($row->name)); ?>",
  "id": <?php echo($row->id); ?>,
  "created": <?php echo($row->created); ?>,
  "description": "<?php echo(htmlspecialchars($row->description)); ?>",
  "perspectives": [
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
  ]
}
