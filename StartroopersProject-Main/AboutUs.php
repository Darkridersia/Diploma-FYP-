<?php

include "Php/config.php";

session_start();
// if user didnt login, bring them to login page
if (!isset($_SESSION['user_email'])) {
  header("Location:login.php");
}
?>
<?php
// search keyword coding part
if (isset($_POST['search'])) {

  $transfer = $_POST['input'];

  $sql = "SELECT * FROM productmain2 WHERE p_name LIKE '%" . $transfer . "%'";

  $result = mysqli_query($conn, $sql);

  $products = mysqli_fetch_all($result, MYSQLI_ASSOC);

  if (mysqli_num_rows($result) == 0) {

    echo '<script>alert("Product not found or similar product not found")</script>';

    $sql = "SELECT * FROM productmain2";
    $result = mysqli_query($conn, $sql);
    $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
  }
  header("Location:SearchKeywordItem.php?searchkeyword=$transfer");
}
?>

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
  <script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
  <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>

  <!-- google font-->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Glory:wght@500&display=swap" rel="stylesheet">
  <!-- font-family: 'Glory', sans-serif;   -->
  <!-- google font-->

</head>
<style>
  * {
    font-family: 'Glory', sans-serif;
  }

  .slideimg img {

    border-radius: 30px;

  }

  .slideimg {
    width: 500px;
    height: auto;
    border-radius: 30px;
    box-shadow: 0px 0px 7px black;
    margin: 0px auto;

  }

  h1 {
    font-family: 'Glory', sans-serif;
  }

  .content {
    position: absolute;
    bottom: 0;
    background: rgb(0, 0, 0);
    background: rgb(0, 0, 0, 0.6);
    width: 100%;
    font-size: 20px;
    padding: 20px;
    color: white;
    border-radius: 0px 0px 10px 10px;
    animation: fadeincontent ease 0.5s;
  }

  .contentcase {
    margin: auto;
    height: 500px;
    max-width: 1000px;
    background-color: #787A91;
    border-radius: 10px;

  }

  .imgcase {
    width: 100%;
    height: 100%;
    position: relative;
    box-shadow: 0px 0px 4px black;
    border-radius: 10px;
    animation: fadeinimg ease 0.5s;
  }

  .imgcase img {
    border-radius: 10px;
    width: 100%;
    height: 100%;
    border-radius: 10px;
  }

  @keyframes fadeincontent {
    0% {
      opacity: 0;

    }

    25% {
      opacity: 0.2;
    }

    50% {
      opacity: 0.3;
    }

    75% {
      opacity: 0.4;
    }

    100% {
      opacity: 0.6;
    }
  }

  @keyframes fadeinimg {
    0% {
      opacity: 0;

    }

    20% {
      opacity: 0.2;
    }

    40% {
      opacity: 0.4;
    }

    60% {
      opacity: 0.6;
    }

    80% {
      opacity: 0.8;
    }

    100% {
      opacity: 1;
    }
  }

  .cardcase {
    box-shadow: 0px 0px 10px #6E85B2;
    max-width: 400px;
    min-width: 250px;
    margin: 20px auto;
    height: 500px;
    background-color: #6E85B2;
    padding: 10px;
    animation: fadeinimg ease 0.5s;

  }

  .cardcase li {
    font-size: 20px;

  }

  .cardcase img {
    margin-top: 10px;
    width: 100px;
    height: 100px;

    padding: auto;


  }

  h3 {
    text-align: center;
    font-weight: bold;
    font-family: 'Glory', sans-serif;
    color: blanchedalmond;
  }

  .cardcase a {
    text-shadow: 0px 0px 1px black;
  }

  hr {

    border: black;
  }

  @media screen and (min-width:1106px) {
    .specialtitle {
      margin-bottom: 50px;
    }
  }
</style>

<body>

  <?php include "Php/header.php"; ?>
  <?php include "Php/carticon.php"; ?>
  <br>
  <br>
  <br>
<!-- Introduction part -->
  <div style="margin: 0px 10%;">
    <div class="contentcase">
      <div class="imgcase">
        <img src="Images/photo-1576495199011-eb94736d05d6.jfif" alt="image.jpg">
        <div style="overflow-wrap: break-word;" class="content">
          <h1 style="padding:0px; margin:auto;text-decoration:none;">Introduction</h1>
          <hr>
          <p>
            <b>
              This is a website that is design and build by Sunway College students.

              This website is to make the purchasing of items easier for students
              that might find that some items that they would not use after a well
              or just find it quite expensive.&#x1F4B5;&#x1F4B5;
        </div>
      </div>
    </div>
  </div>
  <!-- Intro second part -->
  <div style="margin: 0px 10px;">
    <hr>
    <div class="row">
      <div class="col-md-12 col-lg-3">

        <div class="cardcase">
          <div style="margin:auto;width:100px;height:auto;">
            <img src="Images/sell.png" alt="image.png">
          </div>
          <h3>Sell Second Hand Item</h3>
          <br>
          <hr>
          <ul>
            <li>
              Go to <a href="AddItemPage.php">here</a> to sell an item!
            </li>
            <br>
            <li>
              Just fill in item details, then you can earn an extra money by selling device/book that you did not use anymore!
            </li>
          </ul>
        </div>

      </div>
      <div class="col-md-12 col-lg-3">

        <div class="cardcase">
          <div style="margin:auto;width:100px;height:auto;">
            <img src="Images/cash-on-delivery.png" alt="image.png">
          </div>
          <h3>Buy Second Hand Item</h3>
          <br>
          <hr>
          <ul>
            <li>
              Thinking of buying some cheap and useful items? <a href="index.php">Choose here!</a>
            </li>
            <br>
            <li>
              Most of the second hand item are sell by college students, item's price is afforadable and reasonable!
            </li>
          </ul>
        </div>

      </div>
      <div class="col-md-12 col-lg-3">

        <div class="cardcase">
          <div style="margin:auto;width:100px;height:auto;">
            <img src="Images/question.png" alt="image.png">
          </div>
          <h3>Having an question?</h3>
          <br>
          <hr>
          <ul>
            <li>
              Go to <a href="Helpsection.php">Help Section</a> to find out your answer!
            </li>

          </ul>
        </div>

      </div>
      <div class="col-md-12 col-lg-3">

        <div class="cardcase">
          <div style="margin:auto;width:100px;height:auto;">
            <img src="Images/contact.png" alt="image.png">
          </div>
          <h3 class="specialtitle">Having unusual problem?</h3>

          <hr>
          <ul>
            <li>
              Feel free to <a href="ContactUs.php">contact us</a>!
            </li>
            <li>
              Our admin will reply you as soon as possible.
            </li>

          </ul>
        </div>

      </div>
    </div>
  </div>
  <hr>
</body>

</html>