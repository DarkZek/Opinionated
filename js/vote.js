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
      parsePolls(result, container);
  }});
}



//
//Parses the poll data and displays it on the page
//
function parsePolls(result, container) {

  if (result == "None") {
    var obj = $(".perspective-container-1")[0];

    $(".no_more_polls").appendTo(obj)[0].style.display = "block";

    obj.classList.add("anim-slideLeftIn");
    obj.style.display = "block";
    return;
  }

  json = JSON.parse(result);

  //This counts the amount of perspectives until we ask for a vote
  var voteCounter = 1;
  //THis counts the amount of perspectives until we ask for their perspective
  var yourPerspectiveCounter = 0;

  //Put in title
  var idObj = $("#title-prefab").clone().appendTo(container);

  //Delete previous poll id
  deleteIdCookie();

  //Set cookie to remember this poll so on refresh they get the same poll
  var d = new Date();
  d.setTime(d.getTime() + (31*24*60*60*1000));
  var expires = "expires="+ d.toUTCString();
  document.cookie = "poll_id=" + json.id + ";" + expires + ";path=/";

  //Set poll data
  idObj.find('#title')[0].innerHTML += json.name + "?";
  idObj.find("#description")[0].innerHTML = json.description;
  $('#id')[0].textContent = json.id;

  poll_id = json.id;

  idObj[0].style.display = "block";

  //
  //Load perspectives
  //

  var perspective = "";
  var perspectiveCount = 0;
  while ((perspective = json.perspectives[perspectiveCount]) != null) {
    perspectiveCount++;

    //Create object to show..
    var prefab = $("#perspective-prefab").clone().appendTo(container);

    //Set perspective display
    prefab[0].style.display = "block";
    prefab[0].id = "";

    //Det perspective data
    prefab.find("#author")[0].textContent += perspective.author;
    prefab.find("#content")[0].innerHTML = parseContent(perspective.content);


    //
    // Show the LETS VOTE message every second perspective
    //
    voteCounter++;
    if (voteCounter == 2) {
      voteCounter = 0;

      var prefab = $("#perspective-vote-prefab").clone().appendTo(container);

      prefab[0].style.display = "block";
      prefab[0].id = "";
    }

    yourPerspectiveCounter++;
    if (yourPerspectiveCounter == 4 && xsrf != "") {
      yourPerspectiveCounter = 0;
      //Show "your perspective"
      var prefab = $("#your-perspective-prefab").clone().appendTo(container);

      prefab[0].style.display = "block";
      prefab[0].id = "";
    }

  }

  //If it never got a chance to ask if you agree or want to submit your own perspective
  if (perspectiveCount < 4) {

    //Show "your perspective"
    var prefab = $("#your-perspective-prefab").clone().appendTo(container);

    prefab[0].style.display = "block";
    prefab[0].id = "";

    voteCounter = 0;

    var prefab = $("#perspective-vote-prefab").clone().appendTo(container);

    prefab[0].style.display = "block";
    prefab[0].id = "";
  }

  //Alternate between using two containers so they can fade in and out at the same time
  if (usingPContainer1) {
    var obj = $(".perspective-container-1")[0];
    obj.classList.add("anim-slideLeftIn");
    obj.style.display = "block";
  } else {
    var obj = $(".perspective-container-2")[0];
    obj.classList.add("anim-slideLeftIn");
    obj.style.display = "block";
  }

  //Check if cookie was saved
  var cookie = atob(getCookie("perspective"));

  if (cookie != "") {
    $("textarea").each(function() {
        $(this)[0].value = cookie;
    });
  }
}

function deleteIdCookie() {
  if (getCookie("poll_id") != "" && getCookie("poll_id") != json.id) {
    //We just got given a new poll. Must have upvoted the last one. Lets delete the perspective
    document.cookie = "poll_id=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
  }
}

function deletePerspectiveCookie() {
  //We just got given a new poll. Must have upvoted the last one. Lets delete the perspective
  document.cookie = "perspective=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
}

function parseContent(content) {
  var regex = /\((.*?)\)+\[(.*?)\]/g;
  var match = regex.exec(content);

  if (match == null) {
    return content;
  }

  for (var i = 1; i < match.length; i += 3) {
    var text = match[i];
    var link = match[i + 1];

    content = content.replace("[" + link + "]", "");
    content = content.replace("(" + text + ")", "<a class='pointer primary' onclick=\"clickLink('" + link + "');\">" + text + "</a>");
  }

  return content;
}

var main_link = "";

function clickLink(link) {
  main_link = link
  $(".leaving-grey")[0].style.display = "block";
  $(".leaving")[0].style.display = "block";
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
    showLoginPage();
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
    showLoginPage();
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
    showLoginPage();
    return false;
  }
  SendUpvoteAPIRequest($("#id")[0].textContent, "/api/polls/skip");
  deletePerspectiveCookie();
}

function LoadNewPoll() {

  SkipPoll();

  if (xsrf == "") {
    showLoginPage();
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








$(document).ready(function() {
  LoadPolls($(".perspective-container-1"));
});







var currentReportId = -1;

//Report functionality
function ShowReport(id) {

  if (xsrf == "") {
    //Not logged in
    showLoginPage();
    return;
  }

  $(".report-div")[0].classList.remove("disabled");
  window.scrollTo(0, 0);
  $("body")[0].style.overflow = "hidden";
  currentReportId = id;
}

function SubmitReport() {

  //Get report reason
  var response = $('input[name=reason]:checked').val();
  var params = {id: currentReportId, reason: response};

  //Send report to server
  sendRequest("/api/polls/reports/report", params);

  //Set animations
  var reportCard = $(".report-card")[0];
  reportCard.classList.remove("anim-slideUpIn");
  reportCard.classList.add("anim-fadeOut");
  var afterDiv = $(".after")[0];
  afterDiv.style.display = "";

  setTimeout(ExitReport, 1000);
}

function ExitReport() {
  $(".report-div")[0].classList.add("disabled");
  var reportCard = $(".report-card")[0];
  reportCard.classList.add("anim-slideUpIn");
  reportCard.classList.remove("anim-fadeOut");
  var afterDiv = $(".after")[0];
  afterDiv.style.display = "none";
  $("body")[0].style.overflow = "";
}
