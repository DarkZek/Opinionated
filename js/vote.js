//Latest poll id
var poll_id = "";

//Load poll to show
function LoadPolls(container) {
  var url = "/api/polls/view";
  var savedId = getCookie("poll_id");
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
  $(".leaving #link-loc")[0].textContent += link;

  $(".leaving .continue").click(function() {
    document.location = main_link;
      $("body")[0].style.overflow = "hidden";
  });
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

/* Unused */
function RemoveUpvotePost(id) {
  SendUpvoteAPIRequest(id, "/api/polls/remove_upvote");
}

function UpvotePost(id) {
  if (xsrf == "") {
    showDialogue('/api/html/login_page');
    return false;
  }
  SendUpvoteAPIRequest(id, "/api/polls/upvote");
  return true;
}

function SendUpvoteAPIRequest(id, url) {
  sendRequest(url, {'id': id })

  deletePerspectiveCookie();
}

function ApiResult(result) {
  if (result != "Success") {
    alert(result);
  }
}

function perspectiveFilledOut(object) {

  if (xsrf == "") {
    showDialogue('/api/html/login_page');
  }

  var text = $(object.parentNode.parentNode).find("textarea")[0].value;

  console.log(text.length);
  if (text.length < 50) {
    //Invalid
    $(object.parentNode.parentNode).find("textarea")[0].setCustomValidity("Minimum of 50 characters");
    return false;
  }

  //Set xsrf
  $(object.parentNode.parentNode).find("#xsrf")[0].value = xsrf;
  $(object.parentNode.parentNode).find("#poll_id")[0].value = poll_id;

  deletePerspectiveCookie();

  return true;
}

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

  SkipPoll();

  if (xsrf == "") {
    showDialogue('/api/html/login_page');
    return;
  }

  var container1 = $(".perspective-container-1");
  var container2 = $(".perspective-container-2");

  var newPollContainer = "";
  var oldPollContainer = "";
  if (usingPContainer1) {
    newPollContainer = container2;
    oldPollContainer = container1;
  } else {
    newPollContainer = container1;
    oldPollContainer = container2;
  }

  //Remove old animations
  newPollContainer[0].classList.remove("anim-slideLeftOut");
  oldPollContainer[0].classList.remove("anim-slideLeftIn");

  //Hide old one
  oldPollContainer[0].classList.add("anim-slideLeftOut");

  hideObject(oldPollContainer[0]);

  //Delete all children
  while (newPollContainer[0].hasChildNodes()) {
    newPollContainer[0].removeChild(newPollContainer[0].lastChild);
  }

  //Load new poll
  LoadPolls(newPollContainer);

  usingPContainer1 = !usingPContainer1;
}

function onType(object) {
  var text = object.value;

  var base64 = btoa(text);

  //Set cookie
  var d = new Date();
  d.setTime(d.getTime() + (31*24*60*60*1000));
  var expires = "expires="+ d.toUTCString();

  document.cookie = "perspective=" + base64 + ";" + expires + ";path=/";
}








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

function ExitReport() {
  hideDialogue($(".grey-out")[0]);
}
