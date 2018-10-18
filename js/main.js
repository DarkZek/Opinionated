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
}

function reshowRegister() {
  showObject(".register_page");
  $('.register_page')[0].classList.remove("anim-slideLeftOut");
  $('.register_page')[0].classList.add("anim-slideLeftIn");

  $('.login_page')[0].classList.add("anim-slideLeftOut");
  $('.login_page')[0].classList.remove("anim-slideLeftIn");

  hideObject(".login_page");
}

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
