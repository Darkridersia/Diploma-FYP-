<?php

include_once('Php/config.php');

require_once "Php/PHPMailer/Exception.php";
require_once "Php/PHPMailer/PHPMailer.php";
require_once "Php/PHPMailer/SMTP.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
// register a admin account
if (!isset($_POST['reg_admin'])) {

    $_SESSION['codeRegisterAdmin'] = "NULL";
 
 }

// Registration form
if (isset($_POST['reg_admin'])) {

    $email = mysqli_real_escape_string($conn, $_POST['user_email']);
    $password = mysqli_real_escape_string($conn, $_POST['user_password']);
    $contact_no = mysqli_real_escape_string($conn, $_POST['user_contact']);
    $code = mysqli_real_escape_string($conn, $_POST['CodeSendedAdmin']);
    $profileimg  = "blank-profile-picture-973460_640.png";

    //change database table name and column name here
    $check = "SELECT * FROM users WHERE user_email = '$email' AND user_role = 'admin'";

    $role = "admin";

    $check = mysqli_query($conn, $check);

    //Format Phone number
    if (preg_match('/^(\d{3})\-(\d{3})\-(\d{4})$/', $contact_no,  $matches) || preg_match('/^(\d{3})(\d{3})(\d{4})$/', $contact_no,  $matches) || preg_match('/^(\d{3})\-(\d{3})(\d{4})$/', $contact_no,  $matches) || preg_match('/^\+\d(\d{3})(\d{3})(\d{4})$/', $contact_no,  $matches)) {

        //Format the phone number to the liking of our database
        $contact_no = $matches[1] . '-' . $matches[2] . '-' . $matches[3];
    }

    //Check if email exist in the database
    if (mysqli_num_rows($check) > 0) {

        echo '<script>alert("Email already been taken")</script>';
        echo "<script>window.location.href='register.php?page=user';</script>";

        //Check phone number amount of digits
    }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){

        echo '<script>alert("Invalid Email")</script>';

    }elseif(strlen($contact_no) < 10) {

        echo '<script>alert("Please make sure you are entering a Malaysia phone number!")</script>';
        echo '<script>alert("Example: 013-XXX-XXXX")</script>';

        // Password formatting
    }elseif((strlen($password) < 8 || !preg_match("#[0-9]+#", $password) || !preg_match("#[A-Z]+#", $password) || !preg_match("#[a-z]+#", $password) || !preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $password))){

        echo '<script>alert("Use 8 or more characters with a mix of letters, numbers & symbols for your password")</script>';

    // to check if the email exist
    }elseif($code != $_SESSION['codeRegisterAdmin']){

        echo '<script>alert("The code is wrong!")</script>';

    }else{

        //change database table name and column name here
        $query = "INSERT INTO users (user_email, user_password, user_contact ,profile_img,user_role)
                            VALUES('$email', '$password', '$contact_no', '$profileimg','$role')";

        mysqli_query($conn, $query);

        $_SESSION['password'] = $password;
        $_SESSION['email'] = $email;
        $_SESSION['contact_no'] = $contact_no;
        $_SESSION['userrole'] = $role;

        echo '<script>alert("Successfully registered")</script>';;
        //Bring the user to the login page, upon registration
        echo "<script>window.location.href='adminlogin.php';</script>";

        unset($_SESSION['codeRegisterAdmin']);

    }
}
// login for admin
//Login form
if (isset($_POST['login_user'])) {

    $email = mysqli_real_escape_string($conn, $_POST['user_email']);
    $password = mysqli_real_escape_string($conn, $_POST['user_password']);

    $password = $password;

    //change database table name and column name here
    $query = "SELECT * FROM users WHERE user_email=
            '$email' AND user_password='$password' AND user_role = 'admin'";

    $results = mysqli_query($conn, $query);

    //Check if user exist in the database
    if (mysqli_num_rows($results) == 1) {

        $_SESSION['user_email'] = $email;
        $_SESSION['user_password'] = $password;

        $user = mysqli_fetch_all($results, MYSQLI_ASSOC);

        foreach ($user as $users) :

            $_SESSION['userrole'] = $users['user_role'];
            $_SESSION['user_contact'] = $users['user_contact'];
        endforeach;

        echo "<script>window.location.href='index.php';</script>";
       
    } else {

        echo '<script>alert("Email or password does not match");
        document.location.href="adminlogin.php";
        
        
        
        </script>';
    }
}

//Check forgot password email form
if (isset($_POST['check_email'])) {

    $email = $_POST['user_email'];
    $code = $_POST['code'];

    $_SESSION['user_email'] = $email;

    //change database table name and column name here
    $query = "SELECT * FROM users WHERE user_email= '$email'";
    $query_1 = "SELECT * FROM users WHERE user_code = '$code'";

    $result = mysqli_query($conn, $query);
    $result_1 = mysqli_query($conn, $query_1);

    // Check if the email and the code exist in the database
    if ((mysqli_num_rows($result) && mysqli_num_rows($result_1)) == 1) {

        echo '<script>alert("Email found")</script>';

        $_SESSION['user_email'] = $email;

        echo "<script>window.location.href='adminchange_password.php';</script>";
    } else {

        echo '<script>alert("This email does not exist or the code is wrong")</script>';
    }
}

//Change password form
if (isset($_POST['change_password'])) {
if(strlen($password) < 8 || !preg_match("#[0-9]+#", $password) || !preg_match("#[A-Z]+#", $password)){
    $password = mysqli_real_escape_string($conn, $_POST['user_password']);

    //change database table name and column name here
    $result = mysqli_query($conn, "UPDATE users SET user_password='$password' WHERE user_email = '" . $_SESSION['user_email'] . "' AND user_role = '".$_SESSION['userrole'] ."' ");
}
    // Check if the email exist in the database
    if ($result == 1) {

        echo '<script>alert("Successfully Updated")</script>';
        echo "<script>window.location.href='adminlogin.php';</script>";
    }
}

if(isset($_POST['sendCodeAdmin'])){

    $name = $_POST['user_email'];
    //Generate random code, to be sent to user email, when user register for the website
    $codeRegister = substr(str_shuffle('123456789abcdefghijklmnopqrstupwxyz'),0,10);

    $_SESSION['codeRegisterAdmin'] = $codeRegister;

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
    
      $mail->addAddress($name, "Dark rider");    
    
      $mail->isHTML(true);
      $mail->Subject = "Registration Code for C.S Mini Shop";
    
    $message ="<h1 style=text-align:center; color:black;>Registration Code</h1>" . "<p><br>**Please do not share this code**</p>
    <tabel>
    <br>
    <br>
    <tr><td>Code</td><td>".  $codeRegister ."</td></tr>
    </tabel>
    ";
    
    $mail->Body = $message;
    
    try{
      
      $mail->send();
      
    }catch(Exception $e){
      echo '<script> alert("Mailer Error: ") </script>' .$mail->ErrorInfo;
    }
    
}

