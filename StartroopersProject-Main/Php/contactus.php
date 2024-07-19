<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once "PHPMailer/Exception.php";
require_once "PHPMailer/PHPMailer.php";
require_once "PHPMailer/SMTP.php";

$mail = new PHPMailer(true);
$mail-> SMTPDebug =0;

$mail->isSMTP();

$mail->Host ='smtp.gmail.com';

$mail->SMTPAuth = true;

$mail->SMTPOptions =array(
  'ssl' => array(
    'verify_peer' =>false,
    'verify_peer_name' =>false,
    'allow_self_signed' => true
)
);

  $mail->Username ='startroopers321@gmail.com';
  $mail->Password ='StarTroopers123';

  $mail->SMTPSecure = "tls";
  $mail->Port =587;

  $mail->From = "startroopers321@gmail.com";

  $mail->addAddress("startroopers321@gmail.com", "Star Troopers");

  $mail->isHTML(true);
  $mail->Subject = "Contact Form Email";

$message ="
<tabel>
<tr><td>Name:</td><td>".$_POST["name"]."</td></tr>
<tr><td>Email:</td><td>".$_POST["email"]."</td></tr>
<tr><td>Message:</td><td>".$_POST["message"]."</td></tr>
</tabel>
";

$mail->Body = $message;

try{
  $mail->send();
  header("location:../index.php");
}catch(Exception $e){
  echo '<script> alert("Mailer Error: ") </script>' .$mail->ErrorInfo;
}
?>