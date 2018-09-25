<?php
$_SESSION["from_nz"] = True;
$from_nz = True;
return;

if (isset($_SERVER['HTTP_CLIENT_IP']))
{
    $ip_address = $_SERVER['HTTP_CLIENT_IP'];
}
if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
{
    $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
}
else
{
    $ip_address = $_SERVER['REMOTE_ADDR'];
}

$url = 'http://ip-api.com/json/' . $ip_address;

$location = json_decode(file_get_contents($url));

if ($location->status != "success" || $location["country"] == "New Zealand" || isset($_SESSION["username"])) {
  $from_nz = True;
} else {
  $from_nz = False;
}

$_SESSION["from_nz"] = $from_nz;
