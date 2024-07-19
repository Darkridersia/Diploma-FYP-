<?php 
session_start();
if (!isset($_SESSION['user_email'])) {
    header("Location:login.php");
  }

  include_once('config.php');
?>

<?php


$v = $_POST['view'];
$b = $_POST['batchid'];
$o = $_POST['order_id'];
$sql = "SELECT * FROM itemhistory WHERE order_id  = $o";
$result = mysqli_query($conn, $sql);
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);

if($v == "purchased"){

    foreach ($products as $product):
$email = $product['seller_email'];

endforeach;
echo '<script>alert("Message sent")</script>';
echo "<script>window.location.href='../viewpurchaseditem.php?batchid=$b';</script>";
} else {
   
    foreach ($products as $product):
    
    $email = $product['buyer_email'];
endforeach;

    echo '<script>alert("Message sent")</script>';
    echo "<script>window.location.href='../viewpurchaseditem.php?batchid=$b';</script>";
  
}

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

  $mail->addAddress("$email", "");

  $mail->isHTML(true);
  $mail->Subject = "ItemID:".$_POST["order_id"].";Message From Customer ";

$message ="
<tabel>
   
    <tr><td>Email:</td><td>".$_POST["email"]."</td></tr>
    <tr><td>Message:</td><td>".$_POST["message"]."</td></tr>
    <tr><td>Item ID:</td><td>".$_POST["order_id"]."</td></tr>
</tabel>
";

$mail->Body = $message;

try{
  $mail->send();
  
}catch(Exception $e){
  echo '<script> alert("Mailer Error: ") </script>' .$mail->ErrorInfo;
}
?>