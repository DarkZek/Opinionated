<?php
//
// Connect to google and check
//
$g_client = new Google_Client();
$g_client->setClientId("594557677828-ecb05iv4dfhepddc1sg0ovq8ohlq2iod.apps.googleusercontent.com ");
$client_secret = trim(file_get_contents("../docs/google_secret.txt"));
$g_client->setClientSecret($client_secret);
$g_client->setRedirectUri("http://haveityourway.co.nz:595/api/login");
$g_client->setScopes("email");
//Step 2 : Create the url
$auth_url = $g_client->createAuthUrl();
echo "<a href='$auth_url'>Login Through Google </a>";
//Step 3 : Get the authorization  code
$code = isset($_GET['code']) ? $_GET['code'] : NULL;
//Step 4: Get access token
if(isset($code)) {
   try {
       $token = $g_client->fetchAccessTokenWithAuthCode($code);
       $g_client->setAccessToken($token);
   }catch (Exception $e){
       echo $e->getMessage();
   }
   try {
       $pay_load = $g_client->verifyIdToken();
       var_dump($pay_load);
   }catch (Exception $e) {
       echo $e->getMessage();
   }
} else{
   $pay_load = null;
}
if(isset($pay_load)){

}
