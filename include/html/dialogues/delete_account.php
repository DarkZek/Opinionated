<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


?>
<script>
var readGuidelines = false;

function submitDeletion() {
  sendRequest("/api/users/account/delete", {password: $("#password")[0].value}, function(data) {
    if (data != "Success") {
      showNotification(data);
    } else {
      window.location = "/";
    }
  });
}
</script>
<form action="/api/polls/submit" class="form-horizontal" method="POST">
  <?php if ($_SESSION["account_type"] === "account") { ?>
    <a>Password</a>
    <input type="password" id="password" class="form-control">
    <br>
    <a class="btn b-red white form-control" onclick="submitDeletion();">PERMANENTLY DELETE ACCOUNT</a>
  <?php } else {

    //
    // Generate URL
    //
    $g_client = new Google_Client();
    $g_client->setState($_SESSION["xsrf_token"]);
    $g_client->setClientId("594557677828-ecb05iv4dfhepddc1sg0ovq8ohlq2iod.apps.googleusercontent.com");
    $client_secret = trim(file_get_contents(__DIR__ . "/../../../docs/accounts/google_secret.txt"));
    $g_client->setClientSecret($client_secret);
    $g_client->setRedirectUri("https://" . $_SERVER['SERVER_NAME'] . "/api/users/account/google/delete");
    $g_client->setScopes("email");

    //Step 2 : Create the url
    $auth_url = $g_client->createAuthUrl();

    ?>
    <a class="btn b-red white form-control" href="<?php echo($auth_url); ?>">PERMANENTLY DELETE ACCOUNT</a>
  <?php } ?>
</form>
