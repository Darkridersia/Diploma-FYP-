
  <?php
  session_start();
  // if user didnt login, bring them to login page
  if (!isset($_SESSION['user_email'])) {
    header("Location:login.php");
  }

  include "Php/processUploadFile2.php";
 // select user's cart and display
  $sql = "SELECT * FROM addtocart WHERE cart_user_email = '" . $_SESSION['user_email'] . "'";
  $result = mysqli_query($conn, $sql);
  $carts = mysqli_fetch_all($result, MYSQLI_ASSOC);
  $sql2 = "SELECT * FROM addtocart WHERE cart_user_email = '" . $_SESSION['user_email'] . "'";
  if ($result2 = mysqli_query($conn, $sql2)) {
    $rowcount = mysqli_num_rows($result2);

  }
  ?>
  <?php
   // clear user's cart
  if (isset($_POST['emptyCart'])) {
    $sqldelete = "DELETE FROM addtocart WHERE cart_user_email = '" . $_SESSION['user_email'] . "'";
    $delete = mysqli_query($conn, $sqldelete);
    header("Location:AddtoCart.php");
  }

  ?>
  <?php

  require_once "Php/connection.php";

  ?>

</div>
<?php


  // remove certain item in user's cart
if (isset($_REQUEST['delete_id'])) {
  // select image from db to delete
  $id = $_REQUEST['delete_id'];  //get delete_id and store in $id variable

  $select_stmt = $db->prepare('SELECT * FROM addtocart WHERE a_id =:id');  //sql select query
  $select_stmt->bindParam(':id', $id);
  $select_stmt->execute();
  $row = $select_stmt->fetch(PDO::FETCH_ASSOC);


  $delete_stmt = $db->prepare('DELETE FROM addtocart WHERE a_id =:id');
  $delete_stmt->bindParam(':id', $id);
  $delete_stmt->execute();
  header("Location:AddtoCart.php");
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
// check out button
if(isset($_POST['checkout'])){
  // check if there is any item that is not available
  $sql = "SELECT p.*,a.* FROM productmain2 p INNER JOIN addtocart a ON p.p_id =a.product_id WHERE p.p_status = 'delete' OR p.p_quantity = 0 AND cart_user_email = '" . $_SESSION['user_email'] . "'";
  $result = mysqli_query($conn, $sql);
 
  $checkrow = mysqli_num_rows($result);
  
  if($checkrow > 0){
    // if yes, pop out a alert box
echo"<script>alert('One of the item is not available, Please delete the item first and proceed to check out!')</script>";
  } else {
    //if not, bring user to check out page
header("Location:checkout.php");
  }
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
  <!-- google font/start -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;300&display=swap" rel="stylesheet">
  <!-- google font/end -->

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
  <!-- font-family: 'Glory', sans-serif;   -->
  <!-- google font-->
</head>
<style>
  * {
    font-family: 'Glory', sans-serif;
  }

  th,
  td {
    padding-left: 20px;
    padding-right: 20px;

    text-align: center;
  }

  a {
    text-decoration: none;

  }

  td {
    border-right: 1px solid blanchedalmond;

  }

  .cartnotification {
    text-align: center;

    font-size: 20px;
    background-color: whitesmoke;
    padding: 20px;
    border-radius: 20px;
box-shadow: 0px 0px 4px whitesmoke;

  }

  .cartnotification a {
    text-decoration: underline;
  }

  .cartnotification svg {
    margin-left: 2px;
    margin-bottom: 15px;
    text-decoration: underline;
  }

  .cartnotification svg:hover {
    color: blue;
    animation: basket 0.5s linear 3;
  }

  @keyframes basket {
    0% {
      transform: rotate(0deg)
    }

    25% {
      transform: rotate(30deg)
    }

    50% {
      transform: rotate(0deg)
    }

    75% {
      transform: rotate(-30deg)
    }

    100% {
      transform: rotate(0deg);
    }


  }

  h1 {
    color: blanchedalmond;

    font-family: 'Glory', sans-serif;
    text-shadow: 0px 0px 2px blanchedalmond;
    display: inline;
  }

  .cart {
    display: inline;
    margin-top: -25px;
    color: blanchedalmond;
  }

  .tablewrapper {
    margin: 100px auto auto auto;
    width: 100%;
    padding: 20px;
    background-color: #6E85B2;
    box-shadow: 0px 0px 4px #6E85B2;
    border-radius: 20px;
    max-width: 1100px;
  }
  .carttitle{
    margin-top: 20px ;
    margin-left: 10px;
  }
</style>

<body>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
  <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>



  <?php
  include "Php/header.php";
  ?>


<!-- if there is no item in cart, show this  -->
  <div class="tablewrapper">
    <?php if ($rowcount == 0) {  ?>
      <div class="cartnotification">
        You have no item in cart, <a href="index.php">ADD SOME!<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-basket2" viewBox="0 0 16 16">
            <path d="M4 10a1 1 0 0 1 2 0v2a1 1 0 0 1-2 0v-2zm3 0a1 1 0 0 1 2 0v2a1 1 0 0 1-2 0v-2zm3 0a1 1 0 1 1 2 0v2a1 1 0 0 1-2 0v-2z" />
            <path d="M5.757 1.071a.5.5 0 0 1 .172.686L3.383 6h9.234L10.07 1.757a.5.5 0 1 1 .858-.514L13.783 6H15.5a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-.623l-1.844 6.456a.75.75 0 0 1-.722.544H3.69a.75.75 0 0 1-.722-.544L1.123 8H.5a.5.5 0 0 1-.5-.5v-1A.5.5 0 0 1 .5 6h1.717L5.07 1.243a.5.5 0 0 1 .686-.172zM2.163 8l1.714 6h8.246l1.714-6H2.163z" />
          </svg></a>


      </div>

    <?php  } else { ?>
      <!-- if there is any item in cart, show this -->
      <div class="carttitle">
        <h1>Your Cart</h1><svg class="cart" xmlns="http://www.w3.org/2000/svg" width="38" height="38" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">

          <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />

        </svg>
      </div>
      <hr style="margin: 5px;">

      <table style="width:100%; height:auto;margin:auto; ">

        <tr>
          <th>Product Name</th>
          <th>Price</th>
          <th>Shipping Type</th>
          <th>Images</th>
          <th>Status</th>
          <th>Quantity</th>
          <th>Total</th>

          <th></th>
        </tr>



        <?php
        // set and initialize variable for total item and total price
        $totalCounter = 0;
        $itemCounter = 0;
        foreach ($carts as $cart) :

 

        ?>

          <form action="" method="POST">
            <!-- display item details -->
            <tr>
              <td><?php echo $cart['product_name'] ?></td>
              <td>RM<?php echo number_format($cart['price'], 2) ?></td>

              <td><?php echo $cart['shipping'] ?></td>
              <td> <img src="Images/<?php echo $cart['images'] ?>" alt="images.jpg"> </td>
              <td>

                <?php
                $sql = "SELECT * FROM productmain2 WHERE p_id  = " . $cart['product_id'] . "";
                $result = mysqli_query($conn, $sql);
                $item = mysqli_fetch_all($result, MYSQLI_ASSOC);
                foreach ($item as $items) :
                  $status =  $items['p_status'];
                  $quantity =  $items['p_quantity'];
                endforeach;
                $total = $cart['price'] * $cart['quantity'];
                $totalCounter += $total;
                $itemCounter += $cart['quantity'];
               
                ?>
                <!-- if this item status is delete, or the quantity is zero, show unavaliable -->
                <?php if($status == "delete" || $quantity == 0) { ?>

                Not available

                  <?php } else {?>


Available

                    <?php } ?>
              </td>
              <td>
                <?php $cartID = $cart['a_id'];
                $Pid = $cart['product_id'];  
                
                $sql = "SELECT p.*,a.* FROM productmain2 p INNER JOIN addtocart a ON p.p_id =a.product_id WHERE a.cart_user_email = '" . $_SESSION['user_email'] . "' AND a.product_id = $Pid ";
          $result = mysqli_query($conn, $sql);
          $searchmax = mysqli_fetch_all($result, MYSQLI_ASSOC);
                 
          foreach ($searchmax as $searchmaxs) :
                
            $max = $searchmaxs['p_quantity'];
          endforeach;
                ?>
                <!-- reset item quantity -->
                <input name="qty" id="qty" style="width:60%;" type="number" value="<?php echo $cart['quantity'] ?>" min="1" max="<?php echo $max ?>">
                <button style="background-color: transparent; border:transparent;display:inline;float:right;width:30%;padding-left:10px;padding-right:10px;" name="update<?php echo $cart['a_id'] ?>">


                  <i class='far fa-edit' style='font-size:24px'></i>


                </button>
                <!-- change item quantity -->
                <?php if (isset($_REQUEST['update'.$cartID])) {
                  $id = $cartID;
                  $quantitysql = "SELECT * FROM addtocart WHERE a_id =  $id";
                  $quantityresult = mysqli_query($conn,$quantitysql);
                  $searchquantity = mysqli_fetch_all($quantityresult,MYSQLI_ASSOC);
                  foreach($searchquantity as $searchquantity):
                  $itemprice = $searchquantity['price'];
                  endforeach;
                  
                  $quantity = $_REQUEST['qty'];
                  $sum = $quantity * $itemprice ;
                 
                  try {

                    $update_stmt = $db->prepare('UPDATE addtocart SET quantity=:p_qty,total_price=:ctotalprice WHERE a_id=:id');
                    $update_stmt->bindParam(':p_qty', $quantity);
                    $update_stmt->bindParam(':ctotalprice',  $sum);
                    $update_stmt->bindParam(':id', $id);

                    if ($update_stmt->execute()) {
                      echo "<meta http-equiv='refresh' content='0;AddtoCart.php'>";
                    }
                  } catch (PDOException $e) {
                    echo $e->getMessage();
                  }
                } ?>
          </form>
          </td>
          <td>

            RM<?php echo number_format("$total", 2); ?>


          </td>
  <!-- delete an item in cart -->
          <td style="border-right: transparent;"><a onclick="return confirm('Are you sure you want to remove this from your cart?')" href="?delete_id=<?php echo $cart['a_id']; ?>" class="btn btn-danger">Delete</a></td>
          </tr>

        <?php endforeach; ?>

        <tr>
          <td style="border: transparent;"></td>
          <td style="border: transparent;"></td>
          <td style="border: transparent;"></td>
          <td style="border: transparent;">

          </td>
          <td style="border: transparent;"></td>
          <td style="border: transparent;">
          <?php
          //count total item
echo ($itemCounter == 1) ? $itemCounter . ' item' : $itemCounter . ' items';
?>

         
          </td>
       <!-- show total price -->

          <td style="border: transparent;"><?php echo "RM" . number_format("$totalCounter", 2); ?></td>

          <td style="border: transparent;">
            <form action="" method="POST">
              <button type="submit" onclick="return confirm('Are you sure you want to clear the whole cart?')" class="btn btn-danger btn-sm" name="emptyCart">Clear Cart</button>
            </form>
          </td>





        </tr>
        <tr>
          <td style="border: transparent;"></td>
          <td style="border: transparent;"></td>
          <td style="border: transparent;"></td>
          <td style="border: transparent;"></td>
          <td style="border: transparent;padding-top:22px;"></td>
          <td colspan="3" style="border: transparent;">
          <form action="AddtoCart.php" method="POST">
          <button style="float: right;" class="btn btn-primary btn-lg" name="checkout"> 
          Check Out
          </button>
             
            </form>
          </td>

          <td style="border: transparent;"></td>



        </tr>
      </table>


  </div>


  </form>
<?php }  ?>
</body>

</html>