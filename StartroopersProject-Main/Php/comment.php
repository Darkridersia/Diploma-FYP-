<?php
include "config.php";
session_start();
if (isset($_POST['submitcomment'])) {
  $errormsg = "";
  $comment = $_POST['comment'];
  $commentsql = "INSERT INTO rating(user_email,comment) VALUES ('$useremail','$comment')";
  $commentresult = mysqli_query($conn, $commentsql);
  if (mysqli_query($conn, $commentsql)) {
    $errormsg = "successful";
    header("location:../ViewDetails.php");
  } else {
    $errormsg = "Error";
  }

  echo $errormsg;
}
?>