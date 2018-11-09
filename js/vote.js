//Load poll to show
function LoadPolls() {
  var url = "/api/polls/view";
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> master
  var savedId = window.location.search.substr(4);

  if (savedId == "") {
    savedId = getCookie("poll_id");
  }

  if (savedId != "") {
    url += "?id=" + savedId;
  }

<<<<<<< HEAD
=======
=======
  var savedId = getCookie("poll_id");
  if (savedId != "") {
    url += "?id=" + savedId;
  }
>>>>>>> master
>>>>>>> master
  $.ajax({url: url, async: true, success: function(result){
      $("body").append(result);
  }});
}

function deletePerspectiveCookie() {
  //We just got given a new poll. Must have upvoted the last one. Lets delete the perspective
  document.cookie = "perspective=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
}

var main_link = "";

function clickLink(link) {
  main_link = link
  showDialogue("/api/html/redirect.php");
<<<<<<< HEAD
=======
  $(".leaving #link-loc")[0].textContent += link;

  $(".leaving .continue").click(function() {
    document.location = main_link;
      $("body")[0].style.overflow = "hidden";
  });
>>>>>>> master
}

function UpvotePost(id) {
  if (xsrf == "") {
    showDialogue('/api/html/login_page');
    return false;
  }
  sendRequest("/api/polls/upvote", {'id': id });
  deletePerspectiveCookie();

  LoadNewPoll();
  return true;
<<<<<<< HEAD
}

function SkipPoll(poll) {
  if (xsrf == "") {
    showDialogue('/api/html/login_page');
    return false;
  }
  sendRequest("/api/polls/skip", {'id': poll});

  LoadNewPoll();
}

function LoadNewPoll() {

  if (xsrf == "") {
    showDialogue('/api/html/login_page');
    return;
=======
}

function SkipPoll(poll) {
  if (xsrf == "") {
    showDialogue('/api/html/login_page');
    return false;
  }
  sendRequest("/api/polls/skip", {'id': poll});

  LoadNewPoll();
}

function LoadNewPoll() {

  if (xsrf == "") {
    showDialogue('/api/html/login_page');
    return;
  }

  window.history.pushState("", "", window.location.origin + window.location.pathname);

  var oldPost = $(".perspective-container");
  oldPost[0].classList.remove("anim-slideLeftIn");
  oldPost[0].classList.add("anim-slideLeftOut");

  Destroy1s(oldPost);

  //Load new poll
  LoadPolls();
}


function perspectiveFilledOut(object) {

  if (xsrf == "") {
    showDialogue('/api/html/login_page');
<<<<<<< HEAD
    return;
=======
>>>>>>> master
>>>>>>> master
  }

  window.history.pushState("", "", window.location.origin + window.location.pathname);

<<<<<<< HEAD
  var oldPost = $(".perspective-container");
  oldPost[0].classList.remove("anim-slideLeftIn");
  oldPost[0].classList.add("anim-slideLeftOut");
=======
  if (text.length < 50) {
    //Invalid
    $(object.parentNode.parentNode).find("textarea")[0].setCustomValidity("Minimum of 50 characters");
    return false;
  }

  //Set xsrf
  $(object.parentNode.parentNode).find("#xsrf")[0].value = xsrf;
  $(object.parentNode.parentNode).find("#poll_id")[0].value = poll_id;
>>>>>>> master

  Destroy1s(oldPost);

  //Load new poll
  LoadPolls();
}

<<<<<<< HEAD

function perspectiveFilledOut(object) {
=======
<<<<<<< HEAD
=======
var usingPContainer1 = true;

function SkipPoll() {
  if (xsrf == "") {
    showDialogue('/api/html/login_page');
    return false;
  }
  SendUpvoteAPIRequest($("#id")[0].textContent, "/api/polls/skip");
  deletePerspectiveCookie();
}

function LoadNewPoll() {
>>>>>>> master


  if (xsrf == "") {
    showDialogue('/api/html/login_page');
    return;
  }

  var text = $(object.parentNode.parentNode).find("textarea")[0].value;

  if (text.length < 50) {
    //Invalid
    $("#comment")[0].setCustomValidity("Minimum of 50 characters");
  }

  deletePerspectiveCookie();

  sendRequest("/api/polls/perspectives/submit", {poll_id: id, content: text, xsrf: xsrf}, function(data) {
    var perspective;
    while ((perspective = $(".your-perspective")).length != 0) {
      perspective.remove();
    }
  });
}
>>>>>>> master


function onType(object) {
  var text = object.value;

  var base64 = btoa(text);

  //Set cookie
  var d = new Date();
  d.setTime(d.getTime() + (31*24*60*60*1000));
  var expires = "expires="+ d.toUTCString();

  document.cookie = "perspective=" + base64 + ";" + expires + ";path=/";
}

<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> master
function ApiResult(result) {
  if (result != "Success") {
    alert(result);
  }
}
<<<<<<< HEAD
=======
=======






>>>>>>> master
>>>>>>> master

var currentReportId = -1;

function SubmitReport() {

  //Get report reason
  var response = $('input[name=reason]:checked').val();
  var params = {id: currentReportId, reason: response};

  //Send report to server
  sendRequest("/api/polls/reports/submit", params);

  //Set animations
  $(".report-div")[0].style.display = "none";

  var afterDiv = $(".afterDiv")[0];
  afterDiv.style.display = "";

  setTimeout(ExitReport, 3000);
}

<<<<<<< HEAD
var showingViewed = false;
function ShowViewedAnimation() {
  if (showingViewed) {
    return;
  }
  
  var viewedIcon = $(".viewed-icon")[0];
  viewedIcon.classList.add("viewed-icon-anim");
  showingViewed = true;

  setTimeout(function () {
    viewedIcon.classList.remove("viewed-icon-anim");
    showingViewed = false;
  }, 1500);
=======
function ExitReport() {
  hideDialogue($(".grey-out")[0]);
<<<<<<< HEAD
}

var showingViewed = false;
function ShowViewedAnimation() {
  if (showingViewed) {
    return;
  }

  var viewedIcon = $(".viewed-icon")[0];
  viewedIcon.classList.add("viewed-icon-anim");
  showingViewed = true;

  setTimeout(function () {
    viewedIcon.classList.remove("viewed-icon-anim");
    showingViewed = false;
  }, 1500);
=======
>>>>>>> master
>>>>>>> master
}
