

  <?php
  session_start();
 
  include "Php/config.php";
 // if user didnt login, bring them to login page
  if (!isset($_SESSION['user_email'])) {
    header("Location:login.php");
  }

  ?>
  <?php
  //get the keyword
  $keyword = $_GET['category_keyword'];
   //select item by keyword
  $sql = "SELECT * FROM productmain2 WHERE p_category = '$keyword';";
  //row count the selected item
  if ($result = mysqli_query($conn, $sql)) {
    $rowcounttest = mysqli_num_rows($result);
  }


  $decimalpoint = $rowcounttest % 12;
  if ($decimalpoint > 0) {
      // if there is a reminder, after divided then plus one(which will add one more page)
    $pagenum = intval(($rowcounttest / 12) + 1);
  } else {
    // divide the row
    $pagenum = intval($rowcounttest / 12);
  }
  ?>
  <?php
  // set page number to 0
  $pagenumber = 0;
  // if the page number is set, get the page number
  if (isset($_REQUEST['PageNum'])) {
    $pagenumber = $_REQUEST['PageNum'];
  }
   // 12 multiple page number, become the record range. Example, first page will select 0-12(12*0 = 0(start from 0 to 12)) records, second page will select 12-24(12*1 = 12(start from 12 to 24))
  $recordrange = 12 *  $pagenumber;

  $sql = "SELECT * FROM productmain2 WHERE p_category = '$keyword' AND p_status = 'active' LIMIT 12 OFFSET $recordrange";
  $result = mysqli_query($conn, $sql);
  $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
  ?>

  <?php
  //If asc is set, run this
  if (isset($_POST['ASC'])) {
    $sort = "ASC";
   
    if (!isset($_GET['PageNum'])) {
      $page = 0;
    } else {
      $page = $_GET['PageNum'];
    }
    header("Location:category.php?category_keyword=$keyword&PageNum=$page&sort=$sort");


  } elseif (isset($_POST['DESC'])) {
     //If desc is set, run this
    $sort = "DESC";
    
    if (!isset($_GET['PageNum'])) {
      $page = 0;
    } else {
      $page = $_GET['PageNum'];
    }
    header("Location:category.php?category_keyword=$keyword&PageNum=$page&sort=$sort"); 
   
  }

 //Get the sort type and get the page number
  if(isset($_GET['sort']) && isset($_GET['PageNum']))
  { 
    $sorting =$_GET['sort'];
    $sql = "SELECT * FROM productmain2 WHERE p_category = '$keyword' AND p_status = 'active' ORDER BY p_price $sorting LIMIT 12 OFFSET $recordrange;";
    //$result = executeQuery($desc_query);
    $result = mysqli_query($conn, $sql);
    $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
  }
  ?>

  <?php
  $sql2 = "SELECT * FROM addtocart WHERE cart_user_email = '" . $_SESSION['user_email'] . "';";
  if ($result2 = mysqli_query($conn, $sql2)) {
    $rowcount = mysqli_num_rows($result2);
  }
  ?>

  <?php
  include_once "Php/config.php";
  $sql3 = "SELECT * FROM category";
  $result3 = mysqli_query($conn, $sql3);
  $categories = mysqli_fetch_all($result3, MYSQLI_ASSOC);
  ?>

</div>
<?php
$useremail = $_SESSION['user_email'];

?>
<!-- search keyword coding part -->
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
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CS.Mini Shop</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous" />

  <link rel="stylesheet" type="text/css" href="Externalstylesheet/style3.css" />

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
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

  <style>
    * {
      font-family: 'Glory', sans-serif;
    }

    .card-title {
      text-align: center;
      font-family: 'Glory', sans-serif;
      color: white;
    }



    img {
      max-width: 100%;
      height: 100%;
      display: block;
      object-fit: fill;
      box-shadow: 0px 4px 4px black;


    }

    .itemimages {
      width: auto;
      border: 5px solid transparent;
      height: 200px;

    }

    .details {
      border: 1.5px solid grey;
      color: #212121;
      width: 100%;
      height: auto;
      box-shadow: 0px 0px 10px #212121
    }

    .btn:hover {
      color: blanchedalmond;
    }

    .cart {
      background-color: black;
      color: white;
      margin: auto;
      font-size: 20px;
      font-weight: 900;
      width: 100%;
      height: 39px;

      box-shadow: 0px 5px 10px #212121;
      font-family: 'Glory', sans-serif;
    }

    .viewdetails a {
      background-color: #A0C1B8;
      margin-top: 6%;
    }

    .viewdetails a:hover::before {
      transform: translate(0, 0);
    }

    .viewdetails a:hover {

      color: #DDDDDD;
      transform: scale(1.05);

    }

    .viewdetails button:hover {

      color: blanchedalmond;
    }

    .cartnumber {
      font-size: 15px;
      float: right;
      margin-right: -45px;
      padding: 1px 9px 1px 9px;
      border: 1px solid #7D0633;
      border-radius: 50%;
      color: #FFD369;
      background-color: #7D0633;
      margin-top: 10px;
    }

    .active {
      display: block;
    }


    .delete {
      display: none;
    }

    .outofstock button {
      font-size: 20px;
      color: white;
      padding: 0px;
      width: auto;
      height: auto;
      margin-top: 10%;
      margin-left: 18%;
      margin-right: 15%;
      padding: 5% 5%;
      border: 4px solid transparent;
      font-family: 'Glory', sans-serif;
      box-shadow: 0px 0px 4px black;
      background-color: #7B113A;
    }

    .case {
      width: 100%;
      max-width: 280px;
      min-width: 200px;
      margin: 4% auto;
      height: 400px;
      animation: fadeinimg ease 0.5s;
      padding: 10px;
      background-image: linear-gradient(500deg, rgba(73, 93, 109, 1) 4.3%, rgba(49, 55, 82, 1) 96.7%);
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.5);
    }

    .containitem {
      margin: 0px 25%;

    }

    .containitemsort {
      margin: 0px 25%;

    }

    .SortBar {
      max-width: 450px;

      border: 1px solid transparent;
      padding: 2px 0px 2px 0px;
      font-family: 'Glory', sans-serif;
      background-color: #DDDDDD;
      border-radius: 5px;

    }

    .SortBar input {
      font-size: 17px;
      margin: 2px;
      margin-right: 20px;
    }

    .sorttext {
      padding-left: 8.5px;
      margin-top: 10px;
      font-family: 'Glory', sans-serif;
      font-size: 17px;
    }

    hr {
      margin: 10px 15%;
    }





    .pagebar {
      margin: 20px 20%;


    }

    .pagebar2 {

      width: auto;
      margin: auto;
      margin-bottom: 20px;


    }

    .pagebar a {
      color: blanchedalmond;
      text-decoration: none;
      font-size: 15px;
      display: inline;


    }

    .pagenumborder {
      display: inline;
      width: 100%;
      height: 100%;

      text-align: center;



    }

    .pagenum {
      width: 50px;

      display: inline-block;
      margin: auto;
      padding: 10px;
    }

    .pagenumactive {
      width: 50px;

      display: inline-block;
      margin: 5px;
      padding: 10px;
      margin: auto;
      background-color: #787A91;
      box-shadow: 0px 0px 4px #787A91;



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
  <?php
  include "Php/header.php";
  ?>
  <div class="row">
    <div class="col-12">
      <a href="AddtoCart.php"> <i class="fa fa-shopping-cart" style="font-size: 65px; padding-top: 10px; padding-right: 35px; float: right;"> </i>
        <span class="cartnumber">
          <?php echo $rowcount;  ?>
        </span>
      </a>
    </div>
  </div>

  <div class="containitemsort">
    <div class="row">
      <form action="#" method="post">
        <div class="SortBar">

          <div class="row">
            <div class="col-md-3">
              <div class="sorttext">
                <span>Sort By:</span>
              </div>
            </div>
            <div class="sortbutton col-md-9">
              <input class="btn btn-primary" type="submit" name="DESC" value="Price(High - Low)">


              <input class="btn btn-primary" type="submit" name="ASC" value="Price(Low - High)">
            </div>
          </div>
        </div>
      </form>

    </div>

  </div>
  <hr>

  <div class="containitem">

    <div class="row">


    
    <?php foreach ($products as $product) : ?>
        <?php $productID = $product['p_id'];
        $qty = $product['p_quantity']; ?>


        <?php require_once "Php/connection.php";

        try {
          $id =  $productID; //get "update_id" from index.php page through anchor tag operation and store in "$id" variable
          $select_stmt = $db->prepare('SELECT * FROM productmain2 WHERE p_id =:id'); //sql select query
          $select_stmt->bindParam(':id', $id);
          $select_stmt->execute();
          $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
          extract($row);
        } catch (PDOException $e) {
          $e->getMessage();
        }
        ?>

        <div class="col-12 col-lg-4">
          <div class="<?php echo $product['p_status'] ?>">
            <div class="case">

              <div class="itemimages">
                <img src="Images/<?php echo $product['p_image']; ?>" class="card-img-top" alt="">
              </div>
              <h4 class="card-title"><?php echo $product['p_name']; ?></h4>
              <h5 class="card-title">RM <?php echo $product['p_price']; ?></h5>
              <?php if ($qty > 0) { ?>
                <div class="viewdetails">
                  <div class="available">
                    <a href="ViewDetails.php?productID=<?php echo $productID ?>" style="font-family: 'Glory', sans-serif; font: size 20px;" name="viewDetails" class="btn details px-auto">VIEW DETAILS</a>
                  </div>
                </div>
                <div style="display: none;">
                  <form method="POST" enctype="multipart/form-data">
                    <input type="text" name="pid" id="pid" value="<?php echo $product['p_id']; ?>">
                    <input type="text" name="pname" id="pname" value="<?php echo $product['p_name']; ?>">
                    <input type="text" name="price" id="price" value="<?php echo $product['p_price']; ?>">
                    <input type="text" name="stock" id="stock" value="1">
                    <input type="text" name="shipping" id="shipping" value="<?php echo $product['p_shipping']; ?>">
                    <input type="text" name="iemail" id="iemail" value="<?php echo $product['user_email']; ?>">
                    <input type="text" name="cno" id="cno" value="<?php echo $product['user_phone']; ?>">
                    <input type="text" name="maxnum" id="maxnum" value="<?php echo $product['p_quantity']; ?>">
                    <input type="text" name="pstatus" id="pstatus" value="<?php echo $product['p_status']; ?>">
                    <div class="form-group text-center">

                      <div class="form-group text-center">
                        <input type="file" name="txt_file" class="form-control" value="<?php echo $product['p_image']; ?>" />
                        <p><img src="Images/<?php echo $product['p_image']; ?>" height="100" width="100" /></p>
                      </div>
                    </div>
                </div>
                <button class="addtocart cart px-auto" name="add<?php echo $product['p_id']; ?>" style="background-color:black;border:none;">ADD TO CART</button>
                </form>
              <?php } else {   ?>

                <div class="outofstock">
                  <button disabled>OUT OF STOCK

                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red" class="bi bi-x-circle" viewBox="0 0 16 16">
                      <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                      <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                    </svg>
                  </button>
                </div>
              <?php } ?>
            </div>

          </div>
        </div>
      <?php

 //  user click add to cart button
        if (isset($_REQUEST['add' . $productID])) {


          $Pid  = $_REQUEST['pid'];
          $stock = $_REQUEST['stock'];
          $quantityvalue = 0;
          $Pid  = $_REQUEST['pid'];
          $stock = $_REQUEST['stock'];
       

          $sql2 = "SELECT * FROM addtocart WHERE cart_user_email = '" . $_SESSION['user_email'] . "' AND  product_id = ' $Pid ';";
          $resultrow = mysqli_query($conn, $sql2);
          $cartitem = mysqli_fetch_all($resultrow, MYSQLI_ASSOC);
          foreach ($cartitem as $cartitems) :

            $quantityvalue =   $cartitems['quantity'];
            $max = $cartitems['max_item'];

          endforeach;
         
          $stock = $stock + $quantityvalue;
            // check if there is any same item in cart and quantity, if there is a same item, and the quantity did not reach the item's stock, run this.
          if (mysqli_num_rows($resultrow) == 1 && $stock <= $max) {


            $update_stmt = $db->prepare('UPDATE addtocart SET quantity =:c_quantity'); //sql insert query					
            $update_stmt->bindParam(':c_quantity', $stock);
            $update_stmt->execute();
             //if there is no same item in cart, run this
          } elseif (mysqli_num_rows($resultrow) == 0) {
            try {

              $pname  = $_REQUEST['pname'];
              //textbox name "txt_name"
              $price = $_REQUEST['price'];
              $Pid  = $_REQUEST['pid'];
              $stock = $_REQUEST['stock'];
              $shipping = $_REQUEST['shipping'];
              $Iemail = $_REQUEST['iemail'];
              $Cno = $_REQUEST['cno'];
              $maxNum = $_REQUEST['maxnum'];
              $image_file  = $_FILES["txt_file"]["name"];
              $type    = $_FILES["txt_file"]["type"];  //file name "txt_file"
              $size    = $_FILES["txt_file"]["size"];
              $temp    = $_FILES["txt_file"]["tmp_name"];
              $status = $_REQUEST['pstatus'];

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
                $insert_stmt = $db->prepare('INSERT INTO addtocart(product_name,price,quantity,shipping,images,total_price,seller_email,seller_contactNo,product_id,cart_user_email,max_item,status) VALUES(:aname,:aprice,:aquantity,:ashipping,:aimage,:atotalprice,:aseller_email,:aseller_contactNo,:aproduct_id,:acart_user_email,:amax_item,:astatis)'); //sql insert query					
                $insert_stmt->bindParam(':aname', $pname);
                $insert_stmt->bindParam(':aprice', $price);
                $insert_stmt->bindParam(':aquantity', $stock);
                $insert_stmt->bindParam(':ashipping', $shipping);
                $insert_stmt->bindParam(':aimage', $image_file);
                $insert_stmt->bindParam(':atotalprice', $price);
                $insert_stmt->bindParam(':aseller_email', $Iemail);
                $insert_stmt->bindParam(':aseller_contactNo', $Cno);
                $insert_stmt->bindParam(':aproduct_id', $Pid);
                $insert_stmt->bindParam(':acart_user_email', $useremail);
                $insert_stmt->bindParam(':amax_item', $maxNum);
                $insert_stmt->bindParam(':astatis', $status);
                //bind all parameter 
                if ($insert_stmt->execute()) {

                  echo "<meta http-equiv='refresh' content='0;'>";
                }
              }
            } catch (PDOException $e) {
              echo $e->getMessage();
            }
          } else {
            echo '<script type="text/javascript">alert("You have added/reached the maximum quantity of this item.")</script>';
          }
        }

      endforeach;

      ?>





    </div>

  </div>
  <hr>
  <div class="pagebar">
    <div class="row">

      <div class="pagebar2">





  
        <?php
    // get the sort type
        if (isset($_GET['sort'])) {
          $sort = $_GET['sort'];

        ?>
          <?php
          $classname = "";
          for ($i = 0; $i < $pagenum; $i++) {
            //if the page number is equal to i, make the class name to active
            if ($pagenumber == $i) {
              $classname = "active";
            } else {
              $classname = "";
            }

          ?>


          <?php } ?>

          <form method="">

            <?php if (isset($_REQUEST['PageNum']) && $_REQUEST['PageNum'] == 0) {
            ?>
               <!-- isset page number is equal to 0, do not display the left arrow -->
              <div style="display: none;">
                <a href="?category_keyword=<?php echo $keyword ?>&PageNum=<?php echo $_REQUEST['PageNum'] - 1 ?>&sort=<?php echo $sort ?>"> <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-caret-left" viewBox="0 0 16 16">
                    <path d="M10 12.796V3.204L4.519 8 10 12.796zm-.659.753-5.48-4.796a1 1 0 0 1 0-1.506l5.48-4.796A1 1 0 0 1 11 3.204v9.592a1 1 0 0 1-1.659.753z" />
                  </svg></a>

              </div>

            <?php } else { ?>


              <a href="?category_keyword=<?php echo $keyword ?>&PageNum=<?php if (!isset($_GET['PageNum'])) {
      $page = 0;
    } else {
      $page = $_GET['PageNum'];
    } echo $page - 1 ?>&sort=<?php echo $sort ?>"> 
      <!-- (left arrow)if page number did not set, set $page as 1, if it is set , get the page number and plus one-->
    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-caret-left" viewBox="0 0 16 16">
                  <path d="M10 12.796V3.204L4.519 8 10 12.796zm-.659.753-5.48-4.796a1 1 0 0 1 0-1.506l5.48-4.796A1 1 0 0 1 11 3.204v9.592a1 1 0 0 1-1.659.753z" />
                </svg></a>


            <?php } ?>


            <?php
            $classname = "";
            for ($i = 0; $i < $pagenum; $i++) {
              if ($pagenumber == $i) {
                $classname = "active";
              } else {
                $classname = "";
              }

            ?>

              <div class="pagenumborder">
                <div class="pagenum<?php echo $classname ?>">
                  <a href="?category_keyword=<?php echo $keyword ?>&PageNum=<?php echo $i ?>&sort=<?php echo $sort ?>"><?php echo $i + 1 ?></a>
                </div>
              </div>


            <?php } ?>
            <?php if (isset($_REQUEST['PageNum']) && $_REQUEST['PageNum'] == $i - 1) { ?>

              <div style="display: none;">
                <a href="?category_keyword=<?php echo $keyword ?>&PageNum=<?php echo $_REQUEST['PageNum'] - 1 ?>&sort=<?php echo $sort ?>"> <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-caret-left" viewBox="0 0 16 16">
                    <path d="M10 12.796V3.204L4.519 8 10 12.796zm-.659.753-5.48-4.796a1 1 0 0 1 0-1.506l5.48-4.796A1 1 0 0 1 11 3.204v9.592a1 1 0 0 1-1.659.753z" />
                  </svg></a>

              </div>


            <?php } else { ?>
                    <!-- (right arrow)if page number did not set, set $page as 1, if it is set , get the page number and plus one-->
              <a href="?category_keyword=<?php echo $keyword ?>&PageNum=<?php if (!isset($_GET['PageNum'])) {
      $page = 1;
    } else {
      $page = $_GET['PageNum'];
    } echo $page + 1 ?>"> <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-caret-right" viewBox="0 0 16 16">
                  <path d="M6 12.796V3.204L11.481 8 6 12.796zm.659.753 5.48-4.796a1 1 0 0 0 0-1.506L6.66 2.451C6.011 1.885 5 2.345 5 3.204v9.592a1 1 0 0 0 1.659.753z" />
                </svg></a>

            <?php } ?>
          </form>


      </div>
    </div>
  </div>

<?php } else { ?>




  <?php
          $classname = "";
          for ($i = 0; $i < $pagenum; $i++) {
            if ($pagenumber == $i) {
              $classname = "active";
            } else {
              $classname = "";
            }

  ?>


  <?php } ?>

  <form method="">






    <?php if (isset($_REQUEST['PageNum']) && $_REQUEST['PageNum'] == 0 ||  $rowcounttest <= 12) {
    ?>
    <!-- isset page number is equal to 0, do not display the left arrow -->
      <div style="display: none;">
        <a href="?category_keyword=<?php echo $keyword ?>&PageNum=<?php echo $_REQUEST['PageNum'] - 1 ?>"> <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-caret-left" viewBox="0 0 16 16">
            <path d="M10 12.796V3.204L4.519 8 10 12.796zm-.659.753-5.48-4.796a1 1 0 0 1 0-1.506l5.48-4.796A1 1 0 0 1 11 3.204v9.592a1 1 0 0 1-1.659.753z" />
          </svg></a>

      </div>

    <?php } else { ?>


      <a href="?category_keyword=<?php echo $keyword ?>&PageNum=<?php if (!isset($_GET['PageNum'])) {
      $page = 0;
    } else {
      $page = $_GET['PageNum'];
    } echo $page - 1 ?>"> <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-caret-left" viewBox="0 0 16 16">
          <path d="M10 12.796V3.204L4.519 8 10 12.796zm-.659.753-5.48-4.796a1 1 0 0 1 0-1.506l5.48-4.796A1 1 0 0 1 11 3.204v9.592a1 1 0 0 1-1.659.753z" />
        </svg></a>


    <?php } ?>


    <?php
        //for loop to to create page number based on the divided number at the start
          $classname = "";
          for ($i = 0; $i < $pagenum; $i++) {
            if ($pagenumber == $i) {
              $classname = "active";
            } else {
              $classname = "";
            }

    ?>

      <div class="pagenumborder">
        <div class="pagenum<?php echo $classname ?>">
          <a href="?category_keyword=<?php echo $keyword ?>&PageNum=<?php echo $i ?>"><?php echo $i + 1 ?></a>
        </div>
      </div>


    <?php } ?>
    <?php if (isset($_REQUEST['PageNum']) && $_REQUEST['PageNum'] == $i - 1 ||  $rowcounttest <= 12) { ?>
 <!-- isset page number is equal to the max page number, do not display the right arrow -->
      <div style="display: none;">
        <a href="?category_keyword=<?php echo $keyword ?>&PageNum=<?php echo $_REQUEST['PageNum'] - 1 ?>"> <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-caret-left" viewBox="0 0 16 16">
            <path d="M10 12.796V3.204L4.519 8 10 12.796zm-.659.753-5.48-4.796a1 1 0 0 1 0-1.506l5.48-4.796A1 1 0 0 1 11 3.204v9.592a1 1 0 0 1-1.659.753z" />
          </svg></a>

      </div>


    <?php } else { ?>
      <a href="?category_keyword=<?php echo $keyword ?>&PageNum=<?php if (!isset($_GET['PageNum'])) {
      $page = 1;
    } else {
      $page = $_GET['PageNum'];
    } echo $page + 1 ?>"> <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-caret-right" viewBox="0 0 16 16">
          <path d="M6 12.796V3.204L11.481 8 6 12.796zm.659.753 5.48-4.796a1 1 0 0 0 0-1.506L6.66 2.451C6.011 1.885 5 2.345 5 3.204v9.592a1 1 0 0 0 1.659.753z" />
        </svg></a>

    <?php } ?>
  </form>


  </div>
  </div>
  </div>
<?php } ?>
</body>