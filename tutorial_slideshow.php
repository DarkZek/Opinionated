
<?php

$NAV_TAB = "HOME";
$TITLE = "Opinionated | How it works";
require("/var/www/html/include/html/html_structure.php");
?>
<script src="/js/tutorial.js"></script>
<link href="/css/tutorial.css" rel="stylesheet">
<link href="/css/main_tutorial.css" rel="stylesheet">
<div class="m-container">
<!-- Skip button -->
<div class="skip">
  <b id="skip" onclick="document.location = '/';" class="pointer gray">SKIP</b>
</div>
<div class="slide slide-1 animated">
  <div class="container">
    <h1 class="primary animated anim-popIn">OPINIONATED</h1>
    <a class="subtitle animated anim-glideDown">How it all works</a>
  </div>
</div>

<div class="slide slide-2 animated" style="display: none;">
  <div class="container">
    <div class="poll-animation row">
      <i class="material-icons voting">how_to_vote</i>
      <i class="material-icons upvote upvote-1 animated anim-upvote">forward</i>
      <i class="material-icons upvote upvote-2 animated anim-upvote">forward</i>
      <i class="material-icons upvote upvote-3 animated anim-upvote">forward</i>
    </div>
    <div class="row">
      <a class="container subtitle animated anim-glideDown justified">You submit polls to Opinionated, we display them on our voting page and New Zealand decides if we want to vote on your idea based off the upvotes it recieves</a>
    </div>
  </div>
</div>

<div class="slide slide-3 animated" style="display: none;">
  <div class="container">
    <div class="main-poll-animation row">
      <i class="material-icons face">face</i>
      <i class="material-icons upvote animated anim-long-upvote">forward</i>
      <i class="material-icons downvote animated anim-downvote">forward</i>
    </div>
    <div class="row">
      <a class="container subtitle animated anim-glideDown justified">At the end of every month the poll with the highest upvotes is chosen to be Opinionated's monthly poll! The next month the voting begins. New Zealand votes on what they think about your idea and voting is closed one week before the next month to discuss ways New Zealand could implement your poll</a>
    </div>
  </div>
</div>

<div class="slide slide-4 animated" style="display: none;">
  <div class="container">
    <div class="animation row">
      <i class="material-icons n1 animated anim-hover">sentiment_satisfied_alt</i>
      <i class="material-icons n2 animated anim-hover ">sentiment_satisfied_alt</i>
      <i class="material-icons n3 animated anim-hover ">sentiment_satisfied_alt</i>
      <i class="material-icons n4 animated anim-hover ">sentiment_satisfied_alt</i>
      <i class="material-icons n5 animated anim-hover ">sentiment_satisfied_alt</i>
    </div>
    <div class="row">
      <a class="container subtitle animated anim-glideDown center">This poll sparks the push that ends up changing the way New Zealand exists, for the better</a>
    </div>
  </div>
</div>

<div class="slide slide-5 animated" style="display: none;">
  <div class="container">
    <div class="social row" style="cursor: pointer;">
      <i class="fab col-4 fa-facebook" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=https://opinionated.nz/tutorial_slideshow', '_blank');" target="_blank" style="color: #3B5998;"></i>
      <i class="fab col-4 fa-reddit-square" style="color: #ff4500;"></i>
      <i class="fab col-4 fa-twitter cursor" onclick="window.open('https://twitter.com/intent/tweet?text=Opinionated%20is%20a%20New%20Zealand%20website%20to%20share%20your%20ideas%20to%20make%20NZ%20a%20better%20place!%20Learn%20more%20here:%20https://opinionated.nz/tutorial_slideshow', '_blank');" style="color: #1DA1F2;"></i>
    </div>
    <div class="row">
      <a class="container subtitle animated anim-glideDown center">Opinionated only works if people vote here. Spread the word and make New Zealand a better place!</a>
    </div>
  </div>
</div>

<div class="slide slide-6 animated" style="display: none;">
  <div class="container">
    <div class="container animated anim-glideDown">
      <h1 class="subtitle">You're done!</h1>
      <a class="justified">You need an account to vote and submit polls, sign up <b class="primary cursor" onclick="document.location = '/register';">here</b></a>
    </div>
  </div>
</div>

<div class="nativator container">
  <div class="row">
    <div class="col-3 back-col">
      <a class="pointer back grey" onclick="backSlide();">< BACK</a>
    </div>
    <div class="col-6">
      <div>
        <div class="circles">
          <div class="1 circle active"></div>
          <div class="2 circle"></div>
          <div class="3 circle"></div>
          <div class="4 circle"></div>
          <div class="5 circle"></div>
          <div class="6 circle"></div>
        </div>
      </div>
    </div>
    <div class="col-3 next-col">
      <a class="primary next pointer" onclick="nextSlide();">NEXT ></a>
    </div>
  </div>
</div>
</div>
