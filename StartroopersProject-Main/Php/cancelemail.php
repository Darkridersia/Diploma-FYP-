<?php 
  include_once('config.php');
?>

<?php


$q = $_POST['p_quantity'];
$p = $_POST['p_id'];
$o = $_POST['order_id'];

$sql = "SELECT * FROM itemhistory WHERE product_ID = '$p'";
$result = mysqli_query($conn, $sql);

while( $row = mysqli_fetch_array($result)){

  $quantity = $row['Product_quantity'];

}

$sql = "SELECT * FROM productmain2 WHERE p_id = '$p'";
$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_array($result)){

  $quantity2 = $row['p_quantity'];

}

if(isset($_POST['send'])){

  $id = $_POST['order_id'];

  $status = "Cancelled Order";

  $total = $quantity + $quantity2;

  $sql = "UPDATE productmain2 SET p_quantity = '$total' WHERE p_id = '$p' ";
  $sql2 = "UPDATE itemhistory SET Status = '$status' WHERE order_id = '$o' AND product_ID = '$p'";

  $result = mysqli_query($conn, $sql);
  $result2 = mysqli_query($conn, $sql2);

  echo '<script>alert("Successfully cancelled order")</script>';
  echo "<script>window.location.href='../index.php';</script>";
  

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

  $mail->addAddress("startroopers321@gmail.com", "Star Troopers");

  $mail->isHTML(true);
  $mail->Subject = "Purchase history cancellation";

$message ="
<tabel>
    <tr><td>Name:</td><td>".$_POST["name"]."</td></tr>
    <tr><td>Email:</td><td>".$_POST["email"]."</td></tr>
    <tr><td>Message:</td><td>".$_POST["message"]."</td></tr>
    <tr><td>Order ID:</td><td>".$_POST["order_id"]."</td></tr>
</tabel>
";

$mail->Body = $message;

try{
  $mail->send();
  
}catch(Exception $e){
  echo '<script> alert("Mailer Error: ") </script>' .$mail->ErrorInfo;
}
?>