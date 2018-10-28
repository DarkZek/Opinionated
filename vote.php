<?php namespace Opinionated;

$TITLE = "Opinionated | Vote";
$NAV_TAB = "VOTE";
include("./include/html/default_layout.php");

?>
<link href="/css/polls.css" rel="stylesheet">
<script src="/js/vote.js"></script>
<div class="header">
  <div class="container">
    <h1 class="center">DISCOVER NEW POLLS</h1>
    <p class="center">Submit a poll idea or browse through the polls below and upvote polls based on if you want to see change happen in that area. <br>So get voting!</p>
  </div>
  <?php if (isset($_SESSION["display_name"])) { ?>
    <h5 class="submit" style="cursor: pointer;" onclick="showDialogue('/api/html/submit_poll');"><i class="material-icons">edit</i> SUBMIT POLL</h5>
  <?php } ?>
</div>
<a id="id" hidden></a>
<div class="perspective-prefabs">
  <div id="title-prefab" style="display: none;">
    <br class="desktop-only">
    <br>
    <div class="container">
      <h1 class="center" id="title">
        <i class="material-icons report-button" onclick="currentReportId = id; showDialogue('/api/html/report_poll');">report</i>
      </h1>
    </div>
    <h5 class="center" id="date"></h5>
    <div class="container">
        <a class="center" name="description" id="description"></a>
    </div>
    <br>
    <br>
  </div>
  <div style="display: none;" id="perspective-prefab" class="container">
    <div class="row card perspective">
      <br>
      <a class="inline"><i class="material-icons inline">comment</i><b id="author"></b></a>
      <div class="divider"></div>
      <a id="content">"Loading content..."</a>
      <br>
      <div class="divider b-gray"></div>
      <div class="row perspective-settings">
        <div class="col-6 helpful">
          <a><i class="material-icons">thumb_up</i> Helpful</a>
        </div>
        <div class="col-6 perspective-report">
          <a class="right gray"><i class="material-icons">report</i> Report</a>
        </div>
      </div>
      <br>
    </div>
    <br>
  </div>
  <div style="display: none;" id="perspective-vote-prefab" class="container vote">
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
  <form action="/api/polls/perspectives/submit" method="POST" style="display: none;" id="your-perspective-prefab" class="your-perspective vote">
    <div class="container">
      <br>
      <div class="row">
        <a class="center yes-vote btn" style="width: 100%;">Whats your perspective?</a>
      </div>
      <br>
      <div class="row">
        <div class="form-group" style="width: 100%;">
          <textarea minlength="50" maxlength="498" name="content" class="form-control" onchange="onType(this);" style="width: 100%;" rows="5" id="comment"></textarea>
          <input name="xsrf" id="xsrf" value="" hidden type="text">
          <input name="poll_id" id="poll_id" value="" hidden type="text">
          <a style="color: gray">(50) min       (500) max</a>
        </div>
      </div>
      <div class="row">
        <input type="submit" class="center no-vote btn" onclick="return perspectiveFilledOut(this);" style="width: 100%;" value="SUBMIT PERSPECTIVE">
      </div>
      <br>
    </div>
  </form>
</div>
<?php
require("./api/polls/view.php");
