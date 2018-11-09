<<<<<<< HEAD
<?php
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
=======
<?php namespace Opinionated;
>>>>>>> master
>>>>>>> master
>>>>>>> master
>>>>>>> master

//Load Composer's autoloader
require("../vendor/autoload.php");
require("../include/sql/sql.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//
// Load emails & delete
//
$sql = "SELECT * FROM send_emails; TRUNCATE TABLE send_emails;";
$statement = $conn->prepare($sql);
$result = $statement->execute();

$emails = $statement->fetchAll();


//
// Setup server
//

$mail = new PHPMailer(true);
try {
    //Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = trim(file_get_contents("../docs/accounts/email/username.txt"));
    $mail->Password = trim(file_get_contents("../docs/accounts/email/password.txt"));
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

} catch (Exception $e) {
    die('Message could not be sent. Mailer Error: ' . $mail->ErrorInfo);
}

echo("Sending " . count($emails) . " emails\n");

$i = 0;
while(count($emails) > $i) {
  $email = $emails[$i];

  sendNoReply($mail, $email->receiver, $email->title, $email->content);

  $i += 1;
}

/**
* @param mixed $mail Mail Object, $recipient Recipients Email Address, $subject Email Subject, $message Email contents
*
* @return void
**/
function sendNoReply($mail, $recipient, $subject, $message) {

  //Recipients
  $mail->setFrom('no-reply@opinionated.nz', 'Opinionated');
  $mail->addAddress($recipient);
  $mail->addReplyTo('admin@opinionated.nz', 'Opinionated Help Desk');

  //Content
  $mail->isHTML(true);
  $mail->Subject = $subject;
  $mail->Body    = $message;
  $mail->AltBody = $message;

  $mail->send();
}

echo("Done\n");
