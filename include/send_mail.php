<?php
//Load Composer's autoloader
require("/var/www/html/vendor/autoload.php");
require("/var/www/html/include/sql/sql.php");

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
    $mail->Username = 'opinionatednz@gmail.com';
    $mail->Password = 'mpHRynUjm5GuC7oC';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

} catch (Exception $e) {
    die('Message could not be sent. Mailer Error: ', $mail->ErrorInfo);
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
  $mail->isHTML(true);                                  // Set email format to HTML
  $mail->Subject = $subject;
  $mail->Body    = $message;
  $mail->AltBody = $message;

  $mail->send();
}

echo("Done\n");
