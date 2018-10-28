
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
