<?php

session_start();
include_once "Php/config.php";
if (!isset($_SESSION['user_email'])) {
  header("Location:login.php");
}
?>
<?php
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

if (isset($_POST['create_faq'])) {

  $question = $_POST['question'];
  $answer = $_POST['answer'];

  $sql = "INSERT INTO faqs(questions, answer) VALUES('$question', '$answer')";
  $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
  header("location:Helpsection.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CS.Mini Shop</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous" />

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="Externalstylesheet/style3.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
  <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- google font-->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Glory:wght@500&display=swap" rel="stylesheet">
  <!-- font-family: 'Glory', sans-serif;   -->
  <!-- google font-->

</head>
<style>
  * ,h2{
    font-family: 'Glory', sans-serif;
  }
h2{
  text-align: center;
}
.content p{
  font-size: 30px;
}
.CardContainer{
  animation: fadeinimg ease 0.5s;
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
</style>

<body>

  <?php
  include "Php/header.php";
  ?>
  <div class="row">
    <?php

    include "Php/carticon.php";

    ?>
  </div>
  <div style="margin:0px 10%;">
    <div class="row">

      <?php
      $sql = "SELECT * FROM faqs";
      $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
      if (mysqli_num_rows($res) > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
          $questions = $row['questions'];
          $answer = $row['answer'];
      ?>

          <div class="col-12 col-lg-4">
            <div style="margin: auto;" class="CardContainer">
              <div style="max-width: 278px;" class="card">
                <div  class="face face1">
                  <div style="margin-top:58%;" class="content">
                  <div   style="overflow:auto;width: 100%;height:250px;">
                    <!--Answer for help section will appear here-->
                    <p style="font-size: 22px;"><?php echo  $answer ?></p>
                    </div>
                  </div>
                </div>
                <br>
                <div style="max-width: 278px;" class="face face2">
                  <!--Answer for help section will appear here-->
                  <h2> <?php echo  $questions ?></h2>
                </div>
              </div>
            </div>
          </div>

      <?php
        }
      } else {
        echo "There are no FAQs at this time.";
      }
      ?>
     
</body>

</html>