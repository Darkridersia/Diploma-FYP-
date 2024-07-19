<div style="display: none;">
  <?php
  include "Php/openpage.php";
  session_start();
  if (!isset($_SESSION['user_email'])) {
    header("Location:login.php");
  }

  ?>
  <?php

  include "Php/config.php";
  $sql = "SELECT * FROM productmain2";
  $result = mysqli_query($conn, $sql);
  $products = mysqli_fetch_all($result, MYSQLI_ASSOC);

  ?>
  <?php
  $sql2 = "SELECT * FROM addtocart";
  if ($result2 = mysqli_query($conn, $sql2)) {
    $rowcount = mysqli_num_rows($result2);
    echo $rowcount;
  }
  ?>

  <?php
  $sql3 = "SELECT * FROM category";
  $result3 = mysqli_query($conn, $sql3);
  $categories = mysqli_fetch_all($result3, MYSQLI_ASSOC);



  ?>

</div>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CS.Mini Shop</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous" />

  <link rel="stylesheet" type="text/css" href="Externalstylesheet/style3.css" />


  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
  <!-- google font-->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Glory:wght@500&display=swap" rel="stylesheet">
  <style>
    @import url('https://fonts.googleapis.com/css?family=Raleway:400,600,900');

    * {
      box-sizing: border-box;
      /* outline:1px solid ;*/
    }

    body {
      background-color: #2F576E;
      height: 100%;
      margin: 0;
      background-repeat: no-repeat;
      background-attachment: fixed;
    }

    a {
      color: #fff;
      text-decoration: none;
      transition: all 0.30s linear 0s;
    }

    span {
      color: #fff;
    }

    .wrapper-1 {
      width: 50%;
      height: 50vh;
      display: flex;
      flex-direction: column;
    }

    .wrapper-2 {
      padding: 15px;
      text-align: center;
    }

    h1 {
      font-family: 'Raleway', Arial Black, Sans-Serif;
      font-size: 4em;
      font-weight: 900;
      letter-spacing: 3px;
      color: #fafafa;
      margin: 0;
      margin-top: 20px;
      margin-bottom: 40px;
    }

    .wrapper-2 p {
      margin: 0;
      font-size: 1.3em;
      color: #fafafa;
      font-family: 'Raleway', sans-serif;
      letter-spacing: 1px;
      line-height: 1.5;
    }

    @media (min-width:360px) {
      h1 {
        font-size: 4.5em;
      }
    }

    @media (min-width:600px) {
      .thankyoucontent {
        max-width: 1000px;
        margin: 0 auto;
      }

      .wrapper-1 {
        height: initial;
        max-width: 620px;
        margin: 0 auto;
        margin-top: 50px;
      }
    }

    #timer {


      font-family: 'Glory', sans-serif;

    }
  </style>
</head>

<body>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
  <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>


  <div class=thankyoucontent>
    <div class="wrapper-1">
      <div class="wrapper-2">
        <img src="Images/Payment.png" alt="">
        <h1>Thank you!</h1>
        <p>Payment successful</p>
        <span id="timer"></span><!--Timer to redirect-->
      </div>
    </div>
  </div>


  <script type="text/javascript">
    var count = 5;
    var redirect = "index.php";

    function countDown() {
      var timer = document.getElementById("timer");
      //Timer to coundown to redirect to index page
      if (count > 0) {
        count--;
        timer.innerHTML = "This page will redirect to HOME PAGE in " + count + " seconds.";
        setTimeout("countDown()", 1000);
      } else {
        window.location.href = redirect;
      }
    }
    countDown();
  </script>
</body>

</html>