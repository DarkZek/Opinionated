<<<<<<< HEAD
<?php namespace Opinionated;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

?>
=======
>>>>>>> master
<script>
var readGuidelines = false;

function submitPoll() {
  $('#name')[0].value = $('#name')[0].value.replace('?', '');

  if (!readGuidelines) {
    alert("Please read the guidelines before submitting your post");
  }

  return readGuidelines;
}
</script>
<form action="/api/polls/submit" class="form-horizontal" method="POST">
  <input type="text" value="<?php echo($_SESSION["xsrf_token"]); ?>" name="xsrf" hidden>
  <a>Poll Name</a>
  <input name="name" id="name" class="form-control form-control-lg" placeholder="Should New Zealand consider Universal Basic Income?" type="text">
  <a>Description</a>
  <textarea minlength="50" maxlength="498" name="desc" class="form-control" placeholder="Universal Basic Income - or UBI stands for...." style="width: 100%;" rows="5" id="description"></textarea>
  <a>(50) min (500) max</a>
  <br>
  <input type="submit" onclick="return submitPoll();" class="form-control form-control-lg" value="Submit">
</form>
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
</div>

<a class="form-control btn btn-primary anim-fast white animated" onclick="readGuidelines = true; this.classList.add('anim-fadeOut');">Click to unlock submitting</a>
<<<<<<< HEAD
<br>
=======
>>>>>>> master
