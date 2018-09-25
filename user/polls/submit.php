<?php
//Make sure a user is logged in
require("/var/www/html/include/permissions/user_only.php");

$NAV_TAB = "";
$TITLE = "Have it your way";
require("/var/www/html/include/html/default_layout.php");

?>

<div class="header">
  <div class="container">
    <h1 class="center">SUBMIT A POLL</h1>
    <form action="/api/polls/submit" class="form-horizontal" method="POST">
      <input type="text" value="<?php echo($_SESSION["xsrf_token"]); ?>" name="xsrf" hidden>
      <input name="name" id="name" class="form-control form-control-lg" placeholder="Poll Name" type="text">
      <a>Description</a>
      <textarea minlength="50" maxlength="498" name="desc" class="form-control" placeholder="Universal Basic Income - or UBI stands for...." style="width: 100%;" rows="5" id="description"></textarea>
      <a>(50) min (500) max</a>
      <br>
      <input type="submit" onclick="$('#name')[0].value = $('#name')[0].value.replace('?', '');" class="form-control form-control-lg" value="Submit">
    </form>
  </div>
</div>
<br>
<div class="container">
  <h1>Poll Guidelines</h1>
  <h3>Title</h3>
  <p>- Phrase is as a question</p>
  <p>- Make poll questions phrased as neutrally as possible, trying not to impose a view point</p>
  <p>- Be descriptive but presise, "Should New Zealand implement Universal Basic Income" is perfect</p>
  <br>
  <h3>Description</h3>
  <p>The description is used for explaining the concept in the title and providing any extra information. For example if your title was "Should New Zealand implement Universal Basic Income" you would explain what UBI is as well as some news sources explaining the subject.</p>
  <a>
</div>
