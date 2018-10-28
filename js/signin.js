
function showRegister() {
  var loginPage = $(".login-page");

  loginPage[0].classList.add("anim-slideLeftOut");
  loginPage[0].classList.remove("anim-slideLeftIn");

  var registerPage = $(".register-page");

  registerPage[0].classList.remove("anim-slideLeftOut");
  registerPage[0].classList.add("anim-slideLeftIn");
  registerPage[0].style.display = "block";

  var registerPage = $(".content");
  registerPage[0].classList.remove("anim-scaleUp");
  registerPage[0].classList.add("animated");
  registerPage[0].classList.add("anim-scaleDown");
}

function showLogin() {
  var loginPage = $(".login-page");

  loginPage[0].classList.remove("anim-slideLeftOut");
  loginPage[0].classList.add("anim-slideLeftIn");

  var registerPage = $(".register-page");

  registerPage[0].classList.add("anim-slideLeftOut");
  registerPage[0].classList.remove("anim-slideLeftIn");

  var registerPage = $(".content");
  registerPage[0].classList.add("anim-scaleUp");
}

var registering = false;

function sendRegister(obj) {

  if (registering == true) {
    return;
  }
  //registering = true;
  var form = obj.parentNode.parentNode;

  if (!form.checkValidity()) {
    return;
  }

  var username = form[1].value;
  var display_name = form[2].value;
  var psswd = form[3].value;
  var email = form[4].value;
  var recaptcha = form[5].value;

  $.post( "/api/users/account/register", {"account_type": "account", email: email, "username": username, "password": "testing", "display_name": display_name, "g-recaptcha-response": recaptcha, "xsrf": xsrf}, function (data) {
    registering = false;

    data = data.trim();

    if (data.toUpperCase() == "SUCCESS") {
      document.location = "/user/verify_email";
      console.log("moving");
      return;
    }
    switch(data) {
      case "[ERROR] Invalid recatcha token": {
        $(".a-recaptcha")[0].textContent = "Please fill out the recaptcha";
        break;
      }
      case "[ERROR] An account with that username already exists!": {
        $(".a-username")[0].textContent = "There is already a user with this username";
        break;
      }
      case "[ERROR] An account with that email address already exists!": {
        $(".a-email")[0].textContent = "There is already a user with this email";
        break;
      }
    }
  });

  return false;
}
