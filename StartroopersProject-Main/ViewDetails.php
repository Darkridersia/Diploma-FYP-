<?php
include "Php/config.php";
session_start();
//get email and productid
$useremail = $_SESSION['user_email'];

$productID = $_GET['productID'];

if (!isset($_SESSION['user_email'])) {
  // if user didnt login, bring them to login page
  header("Location:login.php");
}

$sql = "SELECT * FROM productmain2 WHERE p_id = $productID;";
$result = mysqli_query($conn, $sql);
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);
foreach ($products as $product) :
  $product['p_quantity'];
endforeach;

?>


<?php
$sql2 = "SELECT * FROM addtocart";
if ($result2 = mysqli_query($conn, $sql2)) {
  $rowcount = mysqli_num_rows($result2);
}
?>


<?php
require_once "Php/connection.php";

try {
  $id =  $productID; 
  $select_stmt = $db->prepare('SELECT * FROM productmain2 WHERE p_id =:id'); //sql select query
  $select_stmt->bindParam(':id', $id);
  $select_stmt->execute();
  $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
  extract($row);
} catch (PDOException $e) {
  $e->getMessage();
}


if (isset($_REQUEST['addtocart'])) {
  $Pid  = $_REQUEST['pid'];
  $stock = $_REQUEST['stock'];
  $quantityvalue = 0;

  $Pid  = $_REQUEST['pid'];
  $stock = $_REQUEST['stock'];
  $quantityvalue = 0;
  
  $sql = "SELECT p.*,a.* FROM productmain2 p INNER JOIN addtocart a ON p.p_id =a.product_id WHERE a.cart_user_email = '" . $_SESSION['user_email'] . "' AND a.product_id = $Pid ";
  $result = mysqli_query($conn, $sql);
  $searchmax = mysqli_fetch_all($result, MYSQLI_ASSOC);
  $sql2 = "SELECT * FROM addtocart WHERE cart_user_email = '" . $_SESSION['user_email'] . "' AND  product_id = ' $Pid ';";
  $resultrow = mysqli_query($conn, $sql2);
  $cartitem = mysqli_fetch_all($resultrow, MYSQLI_ASSOC);
  foreach ($cartitem as $cartitems) :

    $quantityvalue =   $cartitems['quantity'];


  endforeach;
  foreach ($searchmax as $searchmaxs) :
    $max = $searchmaxs['p_quantity'];
  endforeach;
  $stock = $stock + $quantityvalue;
  if (mysqli_num_rows($resultrow) == 1 && $stock <= $max) {
   // check if there is any same item in cart and quantity, if there is a same item, and the quantity did not reach the item's stock, run this.
    $totalprice = $_REQUEST['price'] * $stock;
    $update_stmt = $db->prepare('UPDATE addtocart SET total_price =:c_total,quantity =:c_quantity'); 
    $update_stmt->bindParam(':c_total', $totalprice);				
    $update_stmt->bindParam(':c_quantity', $stock);
    $update_stmt->execute();
    //if there is no same item in cart, run this
  } elseif (mysqli_num_rows($resultrow) == 0) {
    try {
      $pname  = $_REQUEST['pname'];
      $Pid  = $_REQUEST['pid'];  //textbox name "txt_name"
      $price = $_REQUEST['price'];
    
      $stock = $_REQUEST['stock'];
      $totalprice = $_REQUEST['price'] * $stock;
      $shipping = $_REQUEST['shipping'];
      $Iemail = $_REQUEST['iemail'];
      $Cno = $_REQUEST['cno'];

      $image_file  = $_FILES["txt_file"]["name"];
      $type    = $_FILES["txt_file"]["type"];  //file name "txt_file"
      $size    = $_FILES["txt_file"]["size"];
      $temp    = $_FILES["txt_file"]["tmp_name"];

      $path = "Images/" . $image_file; //set upload folder path

      $directory = "Images/"; //set upload folder path for update time previous file remove and new file upload for next use

      if ($image_file) {
        if ($type == "image/jpg" || $type == 'image/jpeg' || $type == 'image/png' || $type == 'image/gif') //check file extension
        {

          if ($size < 5000000) //check file size 5MB
          {

            move_uploaded_file($temp, "Images/" . $image_file);  //move upload file temperory directory to your Images folder	
          } else {
            $errorMsg = "Your File To large Please Upload 5MB Size"; //error message file size not large than 5MB
          }
        } else {
          $errorMsg = "Upload JPG, JPEG, PNG & GIF File Formate.....CHECK FILE EXTENSION"; //error message file extension
        }
      } else {
        $image_file = $row['p_image']; //if you not select new image than previous image sam it is it.
      }

      if (!isset($errorMsg)) {
        $insert_stmt = $db->prepare('INSERT INTO addtocart(product_name,price,quantity,shipping,images,total_price,seller_email,seller_contactNo,product_id,cart_user_email) VALUES(:aname,:aprice,:aquantity,:ashipping,:aimage,:atotalprice,:aseller_email,:aseller_contactNo,:aproduct_id,:acart_user_email)'); //sql insert query					
        $insert_stmt->bindParam(':aname', $pname);
        $insert_stmt->bindParam(':aprice', $price);
        $insert_stmt->bindParam(':aquantity', $stock);
        $insert_stmt->bindParam(':ashipping', $shipping);
        $insert_stmt->bindParam(':aimage', $image_file);
        $insert_stmt->bindParam(':atotalprice',  $totalprice);
        $insert_stmt->bindParam(':aseller_email', $Iemail);
        $insert_stmt->bindParam(':aseller_contactNo', $Cno);
        $insert_stmt->bindParam(':aproduct_id', $Pid);
        $insert_stmt->bindParam(':acart_user_email', $useremail);

        //bind all parameter 
        if ($insert_stmt->execute()) {
          $updateMsg = "File Update Successfully";

          echo "<meta http-equiv='refresh' content='3;ViewDetails.php?productID=$productID'>";
        }
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  } else {
     // when user want to add the item and the item's quantity is equal to it's stock, run this
    echo '<script type="text/javascript">alert("You have added/reached the maximum quantity of this item.")</script>';
  }
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
<?php

$sqlcomment = "SELECT * FROM rating WHERE product_id = $productID";
$searchcomment = mysqli_query($conn, $sqlcomment);
$comments = mysqli_fetch_all($searchcomment, MYSQLI_ASSOC);

?>
<?php
//adding comments
if (isset($_POST['submitcomment'])) {
  $errormsg = "";
  $comment = $_POST['comment'];
  $commentsql = "INSERT INTO rating(user_email,comment,product_id) VALUES ('$useremail','$comment','$productID')";

  if (mysqli_query($conn, $commentsql)) {
    $errormsg = "successful";
    echo "<meta http-equiv='refresh' content='0;ViewDetails.php?productID=$productID'>";
  } else {
    $errormsg = "Error";
  }
}
?>

<!-- delete comments(only for admin) -->
<?php if (isset($_REQUEST['deletecomment'])) {

  $id = $_REQUEST['deletecomment']; 
  $select_stmt = $db->prepare('SELECT * FROM rating WHERE comment_id =:id');  //sql select query
  $select_stmt->bindParam(':id', $id);
  $select_stmt->execute();
  $row = $select_stmt->fetch(PDO::FETCH_ASSOC);


  $delete_stmt = $db->prepare('DELETE FROM rating WHERE comment_id =:id');
  $delete_stmt->bindParam(':id', $id);
  $delete_stmt->execute();
  echo "<meta http-equiv='refresh' content='0;ViewDetails.php?productID=$productID'>";
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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
  <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <link rel="stylesheet" type="text/css" href="Externalstylesheet/style3.css" />
  <link rel="stylesheet" type="text/css" href="Externalstylesheet/ViewDetails4.css" />

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

  h5 {
    font-family: 'Glory', sans-serif;
  }

  input::-webkit-outer-spin-button,
  input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;

  }

  .product-imgs {
    width: 400px;
    margin-top: 115px;
    height: 370px;



  }

  .img-showcase {

    height: 100%;
    width: 100%;


  }

  .img-item {
    height: 100%;
    max-width: 100px;
  }

  .img-select img {
    height: 100%;
  }




  .icon {
    color: black;
  }

  .tabcontent {

    border: transparent;

  }

  .tablinks a {
    text-decoration: none;
    color: white;
  }

  .user {
    display: none;
  }

  .admin {
    display: block;
  }

  .itemborder table th,
  td {
    color: black;
    border: transparent;
  }
</style>

<body>
  <?php
  include "Php/header.php";
  ?>
  <?php

  include "Php/carticon.php";

  ?>
  <?php foreach ($products as $product) : ?>

    <div class="card-wrapper">
      <div class="card">
        <div class="product-imgs">
          <div class="img-display">
            <div class="img-showcase">
              <img src="Images/<?php echo $product['p_image']; ?>" alt="image">
              <img src="Images/<?php echo $product['image2']; ?>" alt="image">
              <img src="Images/<?php echo $product['image3']; ?>" alt="image">
              <img src="Images/<?php echo $product['image4']; ?>" alt="image">
            </div>
          </div>

          <div style="height:80px;" class="img-select">

            <div class="img-item">
              <a href="#" data-id="1">
                <img src="Images/<?php echo $product['p_image']; ?>" alt="image">
              </a>

            </div>
            <div class="img-item">
              <a href="#" data-id="2">
                <img src="Images/<?php echo $product['image2']; ?>" alt="image">
              </a>
            </div>
            <div class="img-item">
              <a href="#" data-id="3">
                <img src="Images/<?php echo $product['image3']; ?>" alt="image">
              </a>
            </div>
            <div class="img-item">
              <a href="#" data-id="4">
                <img src="Images/<?php echo $product['image4']; ?>" alt="image">
              </a>
            </div>
          <?php endforeach; ?>
          </div>
        </div>

        <?php foreach ($products as $product) : ?>

          <div style="margin-top: 100px;font-weight: bold;" class="">
            <h5 style="color: blanchedalmond;" class="title"><?php echo $product['p_name']; ?> </h5>
            <hr style="color: blanchedalmond;">

            <div class="itemborder">

              <table>
                <tr>
                  <th style="font-size: 20px">
                    <strong> Price :</strong>
                  </th>
                  <td style="font-size: 20px">
                    <strong> RM<?php echo $product['p_price']; ?></strong>
                  </td>
                </tr>
                <tr>
                  <th>
                    Contact No :
                  </th>
                  <td>
                    <a target="_blank" href="https://api.whatsapp.com/send?phone=6<?php echo $product['user_phone']; ?>&text=Hi%20there,%20I%20want%20to%20ask%20about%20this%20item,%20<?php echo "Item ID : $productID" ?>"><?php echo $product['user_phone']; ?></a>
                  </td>
                </tr>
                <tr>
                  <th>
                    Seller email :
                  </th>
                  <td>
                    <a href="askitem.php?product_id=<?php echo $productID ?>"> <?php echo $product['user_email']; ?></a>
                  </td>
                </tr>
                <tr>
                  <th>
                    Condition :
                  </th>
                  <td>
                    <?php echo $product['p_condition']; ?>
                  </td>
                </tr>
                <tr>
                  <th>
                    Stock :
                  </th>
                  <td>
                    <?php echo $product['p_quantity']; ?>
                  </td>
                </tr>
                <tr>
                  <th>
                    Quantity :
                  </th>
                  <td>
                    <div class="btnwrapper">


                      <button type="button" class="minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash-circle" viewBox="0 0 16 16">
                          <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                          <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z" />
                        </svg></button>
                      <div style="display: none;">
                        <form method="POST" enctype="multipart/form-data">
                      </div>
                      <input style="width: 60px;font-weight: bold;" type="number" name="stock" id="stock" class="quantity" min="1" max="<?php echo $product['p_quantity']; ?>" value="0">


                      <button type="button" class="plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                          <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                          <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                        </svg></button>


                    </div>

                  </td>
                </tr>



              </table>


              <div style="display: none;">

                <input type="text" name="pid" id="pid" value="<?php echo $product['p_id']; ?>">
                <input type="text" name="pname" id="pname" value="<?php echo $product['p_name']; ?>">
                <input type="text" name="price" id="price" value="<?php echo $product['p_price']; ?>">

                <input type="text" name="shipping" id="shipping" value="<?php echo $product['p_shipping']; ?>">
                <input type="text" name="iemail" id="iemail" value="<?php echo $product['user_email']; ?>">
                <input type="text" name="cno" id="cno" value="<?php echo $product['user_phone']; ?>">
                <div class="form-group text-center">

                  <div class="form-group text-center">
                    <input type="file" name="txt_file" class="form-control" value="<?php echo $product['p_image']; ?>" />
                    <p><img src="Images/<?php echo $product['p_image']; ?>" height="100" width="100" /></p>
                  </div>
                </div>

              </div>



              <br>


              <button id="addtocart" name="addtocart" style="margin:-25px 0px 0px 10px;padding:5px;" class="btn btn-dark btn-lg">

                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
                  <path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z" />
                  <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                </svg> <br>Add To Cart</button>
              </form>
            </div>

          </div>

      </div>
    </div>
    <div style="font-size: larger;font-family: 'Glory', sans-serif;" class="wrapper">

      <div class="tabbar">
        <button class="tablinks" onclick="openTab(event,'Description')">Description</button>
        <button class="tablinks" onclick="openTab(event,'Rating')">Rating</button>
        <button class="tablinks"> <a href="category.php?category_keyword=<?php echo $product['p_category'];  ?>">Product Related</a></button>
      </div>
      <div id="Description" class="tabcontent">
        <h3 style="   font-family: 'Glory', sans-serif;">Description</h3>
        <p><?php echo $product['p_des']; ?></p>
      </div>
    <?php endforeach; ?>
    <div id="Rating" class="tabcontent">

      <h3 style="font-family: 'Glory', sans-serif;">Rating</h3>
      <hr>
      <?php foreach ($comments as $usercomment) : ?>

        <div class="row">
          <div class="col-12">
            <?php
            $useremail = $usercomment['user_email'];
            $sqluser = "SELECT * FROM users WHERE user_email = '$useremail';";
            $resultuser = mysqli_query($conn, $sqluser);
            $user = mysqli_fetch_all($resultuser, MYSQLI_ASSOC);
            foreach ($user as $users) :

            ?>
              <img style="float:left; display: inline;width:30px;margin:-2px 10px 10px 4px;padding:0px;height:30px;border-radius:50%;" src="Images/<?php echo $users['profile_img']; ?>" alt="Images">

            <?php endforeach; ?>
            <p style="display: inline;"><strong><?php echo $usercomment['user_email']; ?> :</strong> </p>
            <div class="<?php echo $_SESSION['userrole']; ?>">

              <a class="btn btn-danger" style="text-decoration: none;float: right;" onclick="return confirm('Are you sure you want to delete this comment?')" href="?productID=<?php echo $productID ?>&deletecomment=<?php echo $usercomment['comment_id']; ?>"> Delete this comment</a>
            </div>
          </div>

          <br>

          <p><?php echo $usercomment['comment']; ?></p>

        </div>

        <hr>

      <?php endforeach; ?>



      <div class="row">
        <form action="" method="POST">
          <input style="display: inline-block;width:50%;border-radius:5px;margin-left:10px;" type="text" name="comment" id="comment" placeholder="Add a comment!">

          <button type="submit" name="submitcomment" id="submitcomment" class="btn btn-primary" required> Comment </button>
        </form>
      </div>
    </div>
    <script src="JS/productTest.js"></script>


</body>

</html>