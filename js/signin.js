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

  console.log("Submitting data..");
  $.post( "/api/users/account/register", {"account_type": "account", email: email, "username": username, "password": "testing", "display_name": display_name, "g-recaptcha-response": recaptcha, "xsrf": xsrf}, function (data) {
    registering = false;

    data = data.trim();

    if (data.toUpperCase() == "Success".toUpperCase()) {
      document.location = "/verify_email";
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
    console.log("Data: " + data);
  });

  return false;
}
