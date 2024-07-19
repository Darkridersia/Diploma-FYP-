<?php

include_once('server.php');
include_once('Php/config.php');

require_once "Php/PHPMailer/Exception.php";
require_once "Php/PHPMailer/PHPMailer.php";
require_once "Php/PHPMailer/SMTP.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (!isset($_POST['reg_user'])) {

    $_SESSION['codeRegister'] = "NULL";
 
 }

 if (!isset($_POST['check_email'])) {

    $_SESSION['codeForgot'] = "NULL";
 
 }


// Registration form

if (isset($_POST['reg_user'])) {

    $email = mysqli_real_escape_string($conn, $_POST['user_email']);
    $password = mysqli_real_escape_string($conn, $_POST['user_password']);
    $contact_no = mysqli_real_escape_string($conn, $_POST['user_contact']);
    $code = mysqli_real_escape_string($conn, $_POST['CodeSended']);
    $profileimg  = "blank-profile-picture-973460_640.png";
    //change database table name and column name here
    $check = "SELECT * FROM users WHERE user_email = '$email' AND user_role = 'user'";
    $role = "user";

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
    }elseif($code != $_SESSION['codeRegister']){

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
        echo "<script>window.location.href='login.php';</script>";

        unset($_SESSION['codeRegister']);

    }
}



//Login form
if (isset($_POST['login_user'])) {

    $email = mysqli_real_escape_string($conn, $_POST['user_email']);
    $password = mysqli_real_escape_string($conn, $_POST['user_password']);

    $password = $password;
    $role = "user";
    //change database table name and column name here
    $query = "SELECT * FROM users WHERE user_email=
            '$email' AND user_password='$password' AND user_role='user'";

    $results = mysqli_query($conn, $query);
    $row = mysqli_num_rows($results);
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

        echo '<script>alert("Email or password does not match")</script>';
    }
}


//Update user profile form
if (isset($_POST['update'])) {

    $sql = "SELECT * FROM users WHERE user_email = '" . $_SESSION['user_email'] . "'";

    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_array($result)) {

        $email =  $row['user_email'];
        $password =  $row['user_password'];
        $contact_no =  $row['user_contact'];
        $profileimg =  $row['profile_img'];

    }
    
    $password = mysqli_real_escape_string($conn, $_POST['user_password']);
    $email = mysqli_real_escape_string($conn, $_POST['user_email']);
    $contact_no = mysqli_real_escape_string($conn, $_POST['user_contact']);

    
    //Format Phone number
    if (preg_match('/^(\d{3})\-(\d{3})\-(\d{4})$/', $contact_no,  $matches) || preg_match('/^(\d{3})(\d{3})(\d{4})$/', $contact_no,  $matches) || preg_match('/^(\d{3})\-(\d{3})(\d{4})$/', $contact_no,  $matches) || preg_match('/^\+\d(\d{3})(\d{3})(\d{4})$/', $contact_no,  $matches)) {

        //Format the phone number to the liking of our database
        $contact_no = $matches[1] . '-' . $matches[2] . '-' . $matches[3];
    }

    if (is_null($profileimg) == true || $profileimg == "") {

        $img = "blank-profile-picture-973460_640.png";

    } else {

        $img = $profileimg;

    }

    if (isset($_FILES['image']['name']) && $_FILES['image']['name'] !== "") {

        $profileImageName = time() . '_' . $_FILES['image']['name'];
        $target = 'Images/' . $profileImageName;



        if((strlen($password) < 8 || !preg_match("#[0-9]+#", $password) || !preg_match("#[A-Z]+#", $password) || !preg_match("#[a-z]+#", $password) || !preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $password))){

            echo '<script>alert("Use 8 or more characters with a mix of letters, numbers & symbols for your password")</script>';

            echo "<script>window.location.href='user_profile.php';</script>";

        }elseif(strlen($contact_no) < 10){

            echo '<script>alert("Please make sure you are entering a Malaysia phone number!")</script>';
            echo '<script>alert("Example: 013-XXX-XXXX")</script>';
    
        }else{

            move_uploaded_file($_FILES['image']['tmp_name'], $target);

            mysqli_query($conn, "UPDATE users SET  user_email='$email', user_password='$password', user_contact='$contact_no',profile_img='$profileImageName' WHERE user_email='" . $_SESSION['user_email'] . "'");

            echo '<script>alert("Successfully updated profile information")</script>';
            echo "<script>window.location.href='user_profile.php';</script>";

        }

    }elseif(isset($_FILES['image']['name']) && $_FILES['image']['name'] == ""){

        if((strlen($password) < 8 || !preg_match("#[0-9]+#", $password) || !preg_match("#[A-Z]+#", $password) || !preg_match("#[a-z]+#", $password) || !preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $password))){

            echo '<script>alert("Use 8 or more characters with a mix of letters, numbers & symbols for your password")</script>';

            echo "<script>window.location.href='user_profile.php';</script>";

        }elseif(strlen($contact_no) < 10){

            echo '<script>alert("Please make sure you are entering a Malaysia phone number!")</script>';
            echo '<script>alert("Example: 013-XXX-XXXX")</script>';
    
        }else{

        $profileImageName = $img;

        //change database table name and column name here
        mysqli_query($conn, "UPDATE users SET  user_email='$email', user_password='$password', user_contact='$contact_no',profile_img='$profileImageName' WHERE user_email='" . $_SESSION['user_email'] . "'");

        echo '<script>alert("Successfully updated profile information")</script>';
        echo "<script>window.location.href='user_profile.php';</script>";

        }   
    }
}


//Check forgot password email form
if (isset($_POST['check_email'])) {

    $email = $_POST['user_email'];
    $code = $_POST['CodeSended'];
    $role = $_GET['page'];

    $_SESSION['user_email'] = $email;
    $_SESSION['userrole'] = $role;

    //change database table name and column name here
    $query = "SELECT * FROM users WHERE user_email= '$email'";

    $result = mysqli_query($conn, $query);

    // Check if the email and the code exist in the database
    if(mysqli_num_rows($result) == 1 && $code ==  $_SESSION['codeForgot']){

        echo '<script>alert("Email found")</script>';

        $_SESSION['user_email'] = $email;
        
        echo "<script>window.location.href='change_password.php';</script>";

    }else{

        echo '<script>alert("This email does not exist or the code is wrong")</script>';

    }
}

//Change password form
if (isset($_POST['change_password'])) {

    $password = mysqli_real_escape_string($conn, $_POST['user_password']);

    if (strlen($password) < 8 || !preg_match("#[0-9]+#", $password) || !preg_match("#[A-Z]+#", $password) || !preg_match("#[a-z]+#", $password) || !preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $password)){

        echo '<script>alert("Use 8 or more characters with a mix of letters, numbers & symbols for your password")</script>';
        
    } else {
       
        $result = mysqli_query($conn, "UPDATE users SET user_password='$password' WHERE user_email = '" . $_SESSION['user_email'] . "'");

        // Check if the email exist in the database
        if ($result == 1) {

            echo '<script>alert("Successfully Updated")</script>';

            if ($_SESSION['userrole'] == "user") {

                echo "<script>window.location.href='login.php';</script>";

            } elseif($_SESSION['userrole'] == "admin") {
            
                echo "<script>window.location.href='adminlogin.php';</script>";
            }
        }

        unset($_SESSION['userrole']);

    }
}

// To check if the email exist
if(isset($_POST['sendCode'])){

    $name = $_POST['user_email'];
    //Generate random code, to be sent to user email, when user register for the website
    $codeRegister = substr(str_shuffle('123456789abcdefghijklmnopqrstupwxyz'),0,10);

    $_SESSION['codeRegister'] = $codeRegister;

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

if(isset($_POST['sendCodeForgotPassword'])){

    $name = $_POST['user_email'];
    //Generate random code, to be sent to user email, when user register for the website
    $codeForgot = substr(str_shuffle('123456789abcdefghijklmnopqrstupwxyz'),0,10);

    $_SESSION['codeForgot'] = $codeForgot;

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
    
      $mail->addAddress($name);    
    
      $mail->isHTML(true);
      $mail->Subject = "Registration Code for C.S Mini Shop";
    
    $message ="<h1 style=text-align:center; color:black;>Registration Code</h1>" . "<p><br>**Please do not share this code**</p>
    <tabel>
    <br>
    <br>
    <tr><td>Code</td><td>".  $codeForgot ."</td></tr>
    </tabel>
    ";
    
    $mail->Body = $message;
    
    try{
      
      $mail->send();
      
    }catch(Exception $e){
      echo '<script> alert("Mailer Error: ") </script>' .$mail->ErrorInfo;
    }    

}

if(isset($_POST['send'])){

  $q = $_POST['p_quantity'];
  $p = $_POST['p_id'];
  $o = $_POST['order_id'];
  
  $sql = "SELECT * FROM itemhistory WHERE product_ID = '$p' AND order_id = '$o' ";
  $result = mysqli_query($conn, $sql);
  
  while($row = mysqli_fetch_array($result)){
  
    $quantity = $row['Product_quantity'];
  
  }
  
  $sql = "SELECT * FROM productmain2 WHERE p_id = '$p' ";
  $result = mysqli_query($conn, $sql);
  
  while($row = mysqli_fetch_array($result)){
  
    $quantity2 = $row['p_quantity'];
  
  }
  
    $status = "Cancelled Order";
  
    $total = $quantity + $quantity2;
  
    $sql = "UPDATE productmain2 SET p_quantity = '$total' WHERE p_id = '$p' ";
    $sql2 = "UPDATE itemhistory SET Status = '$status' WHERE order_id = '$o' AND product_ID = '$p'";
  
    $result = mysqli_query($conn, $sql);
    $result2 = mysqli_query($conn, $sql2);
  
    echo '<script>alert("Successfully cancelled order")</script>';
    echo "<script>window.location.href='index.php';</script>";

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
        $mail->addAddress($_SESSION['user_email'], "Dark rider");
    
    
        $mail->isHTML(true);
        $mail->Subject = "Purchase history cancellation";
    
    $message ="
    <tabel>
        <tr><td>Name:</td><td>".$_POST["name"]."</td></tr>
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
    
}



