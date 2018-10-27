
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

  //No votes yet
  if (percentageDownvotes == 0 && percentageUpvotes == 0) {
    percentageUpvotes = 50;
    percentageDownvotes = 50;
  }

  $(".agree")[0].style.width = percentageUpvotes + "%";
  $(".disagree")[0].style.width = percentageDownvotes + "%";
  $(".agree")[0].style.flex = "0 0 " + percentageUpvotes + "%";
  $(".disagree")[0].style.flex = "0 0 " + percentageDownvotes + "%";

  $(".agree-text")[0].textContent = (Math.round( percentageUpvotes * 10 ) / 10) + "%";
  $(".disagree-text")[0].textContent = (Math.round( percentageDownvotes * 10 ) / 10) + "%";

}

function voteYes() {
  if (xsrf == "") {
    showLoginPage();
    return;
  }

  if (vote == "Up") {
    return;
  }

  upvotes += 1;
  vote = "Up";
  Load();

  $.ajax({url: "/api/main_poll/upvote?xsrf=" + xsrf, success: function(result) {
    if (result == "[ERROR] Already upvoted/downvoted that post!") {
      currentVote = "yes";
      removeVotes();
    }
  }});
}

function voteNo() {
  if (xsrf == "") {
    showLoginPage();
    return;
  }

  if (vote == "Down") {
    return;
  }

  downvotes += 1;
  vote = "Down";
  Load();

  $.ajax({url: "/api/main_poll/downvote?xsrf=" + xsrf, success: function(result) {
    if (result == "[ERROR] Already upvoted/downvoted that post!") {
      currentVote = "no";
      removeVotes();
    }
  }});
}

var currentVote = "";

function removeVotes() {

  if (vote == "Up") {
    upvotes -= 1;
  } else {
    downvotes -= 1;
  }
  Load();

  $.ajax({url: "/api/main_poll/remove_vote?xsrf=" + xsrf, success: function(result) {
    if (currentVote == "yes") {
      voteYes();
    } else {
      voteNo();
    }
  }});
}

$(document).ready(function() {
  Load();
});
