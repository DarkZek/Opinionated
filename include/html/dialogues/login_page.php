<?php
//
//Setup google account linking
//
$g_client = new Google_Client();
$g_client->setClientId("594557677828-ecb05iv4dfhepddc1sg0ovq8ohlq2iod.apps.googleusercontent.com");
$client_secret = trim(file_get_contents(__DIR__ . "/../../docs/accounts/google_secret.txt"));
$g_client->setClientSecret($client_secret);
$g_client->setRedirectUri("https://" . $_SERVER['SERVER_NAME'] . "/api/users/account/google/login");
$g_client->setScopes("email");

//Step 2 : Create the url
$auth_url = $g_client->createAuthUrl();

?>
<link href="/css/login.css" rel="stylesheet" />
<script src='/js/signin.js'></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
var loginWithGoogle = "<?php echo($auth_url); ?>";
</script>


<div class="login-page animated">
 <form class="normal-login">
  <input id="account_type" name="account_type" value="account" hidden=""/>
  <div class="form-group">
   <label for="username">Username</label>
   <input type="text" class="form-control" id="login_username" name="username" />
   <a class="red" id="login_username_error" style="display: none;"></a>
  </div>
  <div class="form-group">
   <label for="password">Password</label>
   <input type="password" class="form-control" id="login_password" name="password" />
   <a class="red" id="login_password_error" style="display: none;"></a>
  </div>
  <div class="form-group">
   <input type="submit" onclick="return sendLogin();" class="form-control" value="LOGIN" />
  </div>
 </form>
 <h4 class="back" hidden onclick="document.location = '/';">BACK &gt;</h4>
 <div class="form-group">
   <a onclick="document.location = loginWithGoogle;" type="submit" class="use-google form-control"><i class="fab fa-google"></i> <div class="google-divider"></div> LOGIN WITH GOOGLE</a>
 </div>
 <br>
 <br>
 <a style="cursor: pointer;" id="login-register-button" class="primary" onclick="showRegister();">Dont have an account? Create one here</a>
</div>






<div class="register-page animated container">
 <br>
 <form class="normal-login" method="POST">
   <input id="account_type" name="account_type" value="account" hidden>
   <div class="form-group">
     <label for="username">Username</label>
     <input type="text" class="form-control" minlength="4" maxlength="25" id="username" required name="username">
     <h6 class="center red a-username"></h6>
     <h6 class="gray" style="font-size: 10px;">min (4) max (25)</h6>
   </div>
   <div class="form-group">
     <label for="display_name">Display Name</label>
     <input type="text" class="form-control" minlength="4" maxlength="25" id="display_name" required name="display_name">
     <h6 class="gray" style="font-size: 10px;">min (4) max (25)</h6>
   </div>
   <div class="form-group">
     <label for="password">Password</label>
     <input type="password" class="form-control" minlength="4" maxlength="25" required id="password" name="password">
     <h6 class="gray" style="font-size: 10px;">min (4) max (25)</h6>
   </div>
   <div class="form-group">
     <label for="email">Email Address</label>
     <input type="email" class="form-control" minlength="4" maxlength="50" required id="email" name="email">
     <h6 class="center red a-email"></h6>
   </div>
   <div class="form-group">
     <div class="g-recaptcha" style="margin-left: 25%;" data-sitekey="6Le1mWEUAAAAAOBDcwb0eE3OAoMZ3qy3N8l38zfB"></div>
   </div>
   <h6 class="center red a-recaptcha"></h6>
   <div class="form-group">
     <input type="submit" class="form-control" onclick="sendRegister(this);return false;" value="REGISTER">
   </div>
 </form>
 <div class="social-l">
  <div class="form-group">
   <br>
    <a href="<?php echo($auth_url); ?>" type="submit" class="use-google pointer form-control"><i class="fab fa-google"></i> <div class="google-divider"></div> REGISTER WITH GOOGLE</a>
  </div>
  </div>
  <br>
  <br>
  <a onclick="showLogin();" class="primary" style="cursor: pointer;">Already have an account? Login here</a>
  <br>
</div>
