<?php namespace Opinionated;

if (!isset($_SESSION["seen_post_register"]) || $_SESSION["seen_post_register"] === 1) {
  return;
}
?>
<link href="/css/post-register.css" id="post-register-css" rel="stylesheet">
<script>
function finishRegister() {

  if ($("#tos")[0].checked == false) {
      alert("Please accept the Opinionated Terms And Conditions");
     $("#tos")[0].focus();
     return;
  }

  sendRequest("/api/users/finish_setup", {email: $("#email")[0].checked}, function(data) {
    if (data == "PwnedAccountSuccess") {
      window.open("/user/accountpwned",'_blank');
      return;
    }
    if (data != "Success") {
      showNotification(data);
    }
  });
  var blackout = $(".backout")[0];

  //Update animations
  blackout.classList.remove("anim-fadeIn");
  blackout.style.animationName = "fadeOut";
  hideObject(blackout);

  var container = $(".post-register-container")[0];
  container.classList.remove("anim-slideUpIn");
  container.classList.add("anim-slideDownOut");
  hideObject(container);
  setTimeout(removeCSS, 1000);
}
function removeCSS() {
  $("#post-register-css")[0].disabled = true;
}
</script>
<div class="backout animated anim-fadeIn anim-fast"></div>
<div class="animated anim-slideUpIn card anim-fast post-register-container">
  <div class="container m-container">
    <div class="col-12">
      <form id="settings" class="settings">
        <h1 class="primary">Lets get you setup</h1>
        <div class="divider"></div><br>
          <div class="form-check">
            <input class="form-check-input" id="email" type="checkbox" value="" id="emails">
            <label class="form-check-label" for="emails">
              I want emails to remind me of Opinionated's monthly polls
            </label>
          </div>
          <br>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="tos">
            <label class="form-check-label" for="tos">
              I agree to Opinionated's Terms Of Service
            </label>
          </div>
          <br>
          <a class="primary" target="_blank" href="/tos">Terms Of Service</a>
          <br>
          <br>
          <a class="primary" target="_blank" href="/privacy">Privacy Policy</a>
          <br>
          <br>
          <a>Opinionated is a <i class="primary">not for profit </i>website. We rely 100% on donations and sponsorships so if you enjoy making New Zealand a better place. Please feel free to donate to us</a>
          <br>
          <br>
          <input class="form-control" type="submit" onclick="finishRegister();return false;" value="FINISH">
        </form>
      </div>
    </div>
  </div>
</div>
