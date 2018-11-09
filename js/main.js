<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
//This only loads the login screen when its needed to save bandwidth :)
function showLoginPage() {
  //If its mobile just redirect
  if (screen.width < 1000) {
    document.location = "/login";
    return;
  }
  $.ajax({url: "/api/html/login_page", async: true, success: function(result){
      $("body").append(result);
      $("body")[0].style.overflow = "hidden";
      window.scrollTo(0, 0);
  }});
}
>>>>>>> master
>>>>>>> master
>>>>>>> master
>>>>>>> master
>>>>>>> master

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

<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> master
>>>>>>> master
>>>>>>> master
>>>>>>> master
function showDialogue(url) {
  args = {};
  args.xsrf = xsrf;
  $.post( url, args, function(data) {
    $("body").append(data);
    $("body")[0].style.overflow = "hidden";
    window.scrollTo(0, 0);
  });
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
=======

function showRegisterPage(object) {
  $.ajax({url: "/api/html/register_page", async: true, success: function(result){
      var register = $("body").append(result);
      $(".register_page")[0].classList.add("anim-slideLeftIn");
  }});

  var parent = object.parentNode.parentNode.parentNode.parentNode;
  parent.classList.remove("anim-slideDown");
  parent.classList.add("anim-slideLeftOut");
  hideObject(".login_page");
}

function reshowLogin() {
  showObject(".login_page");
  $('.login_page')[0].classList.remove("anim-slideLeftOut");
  $('.login_page')[0].classList.add("anim-slideLeftIn");

  $('.register_page')[0].classList.add("anim-slideLeftOut");
  $('.register_page')[0].classList.remove("anim-slideLeftIn");

  $('#login-register-button')[0].onclick = function() {
      reshowRegister();
  };

  hideObject(".register_page");
>>>>>>> master
>>>>>>> master
>>>>>>> master
>>>>>>> master
>>>>>>> master
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
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
