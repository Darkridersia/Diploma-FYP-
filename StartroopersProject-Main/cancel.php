<?php
session_start();
$orderid = $_REQUEST['orderid'];
$productQuantity = $_REQUEST['product_quantity'];
$productId = $_REQUEST['product_id'];
?>

<?php

include('server.php');

$sql = "SELECT * FROM productmain2 WHERE p_id  = $productId";
$result = mysqli_query($conn, $sql);
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);

foreach($products as $product):
  $sellerEmail = $product['user_email'];
endforeach;

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
  <link rel="stylesheet" type="text/css" href="Externalstylesheet/style3.css" />

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
  * {
    font-family: 'Glory', sans-serif;
  }
</style>

<body>


  <?php
  include "Php/header.php";
  ?>
  <?php

  include "Php/carticon.php";

  ?>
  <div class="background">
    <div class="container">
      <div class="screen">
        <div class="screen-header">
          <div class="screen-header-left">
            <div class="screen-header-button close"></div>
            <div class="screen-header-button maximize"></div>
            <div class="screen-header-button minimize"></div>
          </div>
          <div class="screen-header-right">
            <div class="screen-header-ellipsis"></div>
            <div class="screen-header-ellipsis"></div>
            <div class="screen-header-ellipsis"></div>
          </div>
        </div>

        <div class="screen-body">
          <div class="screen-body-item left">
            <div class="app-title">
              <span>Cancel Item</span>
            </div>
            <div class="app-contact">CS.Mini Shop</div>
            <div class="app-contact">Seller E-Mail: <br> <?php echo $sellerEmail ?> </div>
          </div>

          <div class="screen-body-item">
            <div class="app-form">

              <form action="#" method="POST">

                <input type="hidden" name="p_quantity" value="<?php echo $productQuantity ?>">
                <input type="hidden" name="p_id" value="<?php echo $productId ?>">

                <div class="app-form-group">
                  <input class="app-form-control" placeholder="NAME" type="text" name="name" id="name" required>
                </div>

                <div class="app-form-group">
                  <textarea class="app-form-control" placeholder="REASON FOR CANCELLATION" name="message" id="message" cols="20" rows="2" required></textarea>
                </div>

                <div class="app-form-group">

                  <label style="float:left; color:white; font-size: 15px;" readonly>Order ID:</label>

                  <input class="app-form-control" type="text" name="order_id" value="<?php echo $orderid ?>" readonly>
                </div>

                <div class="app-form-group buttons">

                  <button type="reset" class="app-form-button"><a href="purchasedhistory.php" style="text-decoration: none;">CANCEL</a></button>

                  <button type="submit" name="send" class="app-form-button">SEND</button>

                </div>
              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>