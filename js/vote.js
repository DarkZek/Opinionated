//Load poll to show
function LoadPolls() {
  var url = "/api/polls/view";
  var savedId = window.location.search.substr(4);

  if (savedId == "") {
    savedId = getCookie("poll_id");
  }

  if (savedId != "") {
    url += "?id=" + savedId;
  }

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
}

function UpvotePost() {
  if (xsrf == "") {
    showDialogue('/api/html/login_page');
    return false;
  }
  sendRequest("/api/polls/upvote", {'id': id });
  deletePerspectiveCookie();

  LoadNewPoll();
  return true;
}

function SkipPoll() {
  if (xsrf == "") {
    showDialogue('/api/html/login_page');
    return false;
  }
  sendRequest("/api/polls/skip", {'id': id});

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
    return;
  }

  var text = $(object.parentNode.parentNode).find("textarea")[0].value;

  if (text.length < 50) {
    //Invalid
    $("#comment")[0].setCustomValidity("Minimum of 50 characters");
  }

  deletePerspectiveCookie();

  sendRequest("/api/polls/perspectives/submit", {poll_id: id, content: text, xsrf: xsrf}, function(data) {
    if (data != "Success") {
      showNotification(data);
    } else {
      var perspective;
      while ((perspective = $(".your-perspective")).length != 0) {
        perspective.remove();
      }
    }
  });
}

window.onbeforeunload = function() {
  setCookie("perspective", $("#comment")[0].value);
};

function ApiResult(result) {
  if (result != "Success") {
    alert(result);
  }
}

var currentReportId = -1;

function SubmitReport(url) {

  //Get report reason
  var response = $('input[name=reason]:checked').val();
  var params = {id: currentReportId, reason: response};

  //Send report to server
  sendRequest(url, params);

  //Set animations
  $(".report-div")[0].style.display = "none";

  var afterDiv = $(".afterDiv")[0];
  afterDiv.style.display = "";

  setTimeout(ExitReport, 3000);
}

function ExitReport() {
  hideDialogue($(".grey-out")[0]);
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
}
