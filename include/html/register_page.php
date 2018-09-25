<?php
//Setup google account linking
$g_client = new Google_Client();
$g_client->setClientId("594557677828-ecb05iv4dfhepddc1sg0ovq8ohlq2iod.apps.googleusercontent.com");
$g_client->setClientSecret("srXKQxcYeZq7rdtnxFB1JuSp");
$g_client->setRedirectUri("https://opinionated.nz/api/users/account/google/login");
$g_client->setScopes("email");

//Step 2 : Create the url
$auth_url = $g_client->createAuthUrl();
?>
<script src='https://www.google.com/recaptcha/api.js'></script>
<script src='/js/signin.js'></script>
<link href="/css/login.css" rel="stylesheet" />
  <div style="opacity: 0;" class="master container register_page animated">
   <div class="card shadow">
     <div class="header">
      <h2 class="center">REGISTER NEW ACCOUNT</h2>
     </div>
    <div class="container">
     <div class="container">
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
     </div>
     <div class="container">
      <div class="social-l">
       <div class="form-group">
        <br>
        <a href="<?php echo($auth_url); ?>" type="submit" class="use-google pointer form-control"><i class="fab fa-google"></i> <div class="google-divider"></div> REGISTER WITH GOOGLE</a>
       </div>
      </div>
     </div>
     <br>
     <br>
     <div class="container">
       <a onclick="reshowLogin();" class="primary" style="cursor: pointer;">Already have an account? Login here</a>
      </div>
      <br>
    </div>
   </div>
  </div>
