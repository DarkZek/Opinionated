
//
// Utils
//
function sendRequest(url, args, callback) {
  if (args == null) {
    args = {};
  }
  //Add XSRF token
  args.xsrf = xsrf;
  $.post( url, args, function(data) {
    console.log("Data Recieved: " + data);
    if (callback != null) {
      callback(data);
    }
  });
}

function showDialogue(url) {
  args = {};
  args.xsrf = xsrf;
  $.post( url, args, function(data) {
    $("body").append(data);
    $("body")[0].style.overflow = "hidden";
    window.scrollTo(0, 0);
  });
}

function hideDialogue(obj) {
  obj.parentNode.removeChild(obj.nextElementSibling);
  obj.parentNode.removeChild(obj);
  $('body')[0].style.overflow = 'visible';
}

//
// Misc
//
function hideObject(identifier) {
  setTimeout(function () {
    $(identifier)[0].style.display = "none";
  }, 1000);
}
function showObject(identifier) {
  setTimeout(function () {
    $(identifier)[0].style.display = "block";
  }, 1000);
}
function Destroy1s(obj) {
  setTimeout(function () {
    obj.remove();
  }, 1000);
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
            return atob(c.substring(name.length, c.length));
        }
    }
    return "";
}

function setCookie(name, value) {
  var d = new Date();
  d.setTime(d.getTime() + (31*24*60*60*1000));
  var expires = "expires="+ d.toUTCString();
  document.cookie = name + "=" + btoa(value) + ";" + expires + ";path=/";
}

//
// Notification System
//
$.get( "/api/html/notification", function( data ) {
  notificationHTML = data;
});
var notificationHTML = "";

function showNotification(text, actionText, actionCallback) {
  $('body').append(notificationHTML);

  //Set info
  $("#notification-message")[0].textContent = text;
  if (actionText != "") {
    $("#notification-action")[0].textContent = actionText;
  }
  if (actionCallback != null) {
    $("#notification-action").click(function() {
      $(".notification").remove();
      actionCallback();
    });
  }

  //Hide after 5 seconds
  setTimeout(function () {
    $(".notification").remove();
  }, 5000)
}


//
// Show statistics
//
$(document).ready(function() {
  var stats = getCookie("statistics");
  if (stats == "") {
    setCookie("statistics", "true");
    sendRequest("/api/statistics/user", {})
  }
});

//
//Dynamic loading of pages
//
function loadPage(page) {
  window.history.pushState(page, page, page);

  $.post( page, {dynamic: true}, function(data) {
    var html = $("html")[0];
    //Remove all other children except head
    for (var i = 1; i < html.children.length; i++) {
      var child = html.children[i];
      child.parentNode.removeChild(child);
    }

    $("html").append(data);
  });
}
