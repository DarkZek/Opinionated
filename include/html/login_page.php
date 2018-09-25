<?php

//Setup google account linking
$g_client = new Google_Client();
$g_client->setClientId("594557677828-ecb05iv4dfhepddc1sg0ovq8ohlq2iod.apps.googleusercontent.com");
$client_secret = trim(file_get_contents("/var/www/html/docs/mysql/google_secret.txt"));
$g_client->setClientSecret($client_secret);
$g_client->setRedirectUri("https://opinionated.nz/api/users/account/google/login");
$g_client->setScopes("email");

//Step 2 : Create the url
$auth_url = $g_client->createAuthUrl();

?>
<link href="/css/login.css" rel="stylesheet" />
<div onclick="
this.parentNode.removeChild(this.nextElementSibling);
if ($('.register_page')[0] != null) {
  this.parentNode.removeChild($('.register_page')[0]);
}
this.parentNode.removeChild(this);
$(body)[0].style.overflow = 'visible';" class="anim-fast animated anim-fadeIn grey-out"></div>
  <div class="master animated anim-slideDown login_page container anim-fast" style="opacity: 0;">
   <div class="card shadow-sm">
     <div class="header">
      <h2 class="center">LOGIN TO YOUR ACCOUNT</h2>
     </div>
    <div class="container">
     <div class="container">
       <br>
      <form class="normal-login" action="/api/users/account/login" method="POST">
       <input id="account_type" name="account_type" value="account" hidden=""/>
       <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" id="username" name="username" />
       </div>
       <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" />
       </div>
       <div class="form-group">
        <input type="submit" class="form-control" value="LOGIN" />
       </div>
      </form>
      <h4 class="back" hidden onclick="document.location = '/';">BACK &gt;</h4>
     </div>
     <div class="container">
      <div class="social-l">
       <div class="form-group">
        <br>
        <a href="<?php echo($auth_url); ?>" type="submit" class="use-google form-control"><i class="fab fa-google"></i> <div class="google-divider"></div> LOGIN WITH GOOGLE</a>
       </div>
      </div>
     </div>
     <br>
     <br>
     <div class="container">
       <a style="cursor: pointer;" id="login-register-button" class="primary" onclick="showRegisterPage(this);">Dont have an account? Create one here</a>
      </div>
      <br>
    </div>
   </div>
  </div>
