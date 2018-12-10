
var percentageUpvotes = 0;
var percentageDownvotes = 0;

function Load() {
  //Calculate percentages
  if (upvotes != 0) {
    percentageUpvotes = (upvotes / (upvotes + downvotes)) * 100;
  }

  if (downvotes != 0) {
    percentageDownvotes = (downvotes / (upvotes + downvotes)) * 100;
  }

<<<<<<< HEAD
  console.log(downvotes + " " + upvotes);

=======
>>>>>>> master
  //No votes yet
  if (percentageDownvotes == 0 && percentageUpvotes == 0) {
    percentageUpvotes = 50;
    percentageDownvotes = 50;
  }
<<<<<<< HEAD
=======

  $(".yes-bar")[0].style.width = percentageUpvotes + "%";
  $(".no-bar")[0].style.width = percentageDownvotes + "%";
  $(".yes-bar")[0].style.flex = "0 0 " + percentageUpvotes + "%";
  $(".no-bar")[0].style.flex = "0 0 " + percentageDownvotes + "%";
>>>>>>> master

  $(".agree-text")[0].textContent = (Math.round( percentageUpvotes * 10 ) / 10) + "%";
  $(".disagree-text")[0].textContent = (Math.round( percentageDownvotes * 10 ) / 10) + "%";

  if (percentageUpvotes < 5) {
    percentageUpvotes = 15;
    percentageDownvotes = 85;
  } else if (percentageDownvotes < 5) {
    percentageDownvotes = 15;
    percentageUpvotes = 85;
  }

  $(".yes-bar")[0].style.width = percentageUpvotes + "%";
  $(".no-bar")[0].style.width = percentageDownvotes + "%";
  $(".yes-bar")[0].style.flex = "0 0 " + percentageUpvotes + "%";
  $(".no-bar")[0].style.flex = "0 0 " + percentageDownvotes + "%";
}

function voteYes() {
  if (xsrf == "") {
    showDialogue('/api/html/login_page');
    return;
  }

  if (vote == "Up") {
    sendNotification("You've already voted yes to this poll");
    return;
  }

  upvotes += 1;
  vote = "Up";
  Load();

  sendRequest("/api/main_poll/upvote", {}, function(data) {
    if (data != "Success") {
      sendNotification(data);
    }
  });

  showResults();
}

function voteNo() {
  if (xsrf == "") {
    showDialogue('/api/html/login_page');
    return;
  }

  if (vote == "Down") {
    sendNotification("You've already voted no to this poll");
    return;
  }

  downvotes += 1;
  vote = "Down";
  Load();

  sendRequest("/api/main_poll/downvote", {}, function(data) {
    if (data != "Success") {
      sendNotification(data);
    }
  });

  showResults();
}

function showResults() {
  $(".main-vote")[0].style.display = "none";
  $(".main-vote-results")[0].style.display = "block";
}

var currentVote = "";

$(document).ready(function() {
  Load();
});
