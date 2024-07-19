

  <?php
  session_start();
  // if user didnt login, bring them to login page
  if (!isset($_SESSION['user_email'])) {
    header("Location:login.php");
  }
  include "Php/config.php";
  include_once "Php/connection.php";
//add category
  if (isset($_POST['submit'])) {
    $category = $_POST['txt_category'];
    $categoryquery = "INSERT INTO category(CategoryTitle) VALUES ('$category')";
    $msg = "";
    $insert =  mysqli_query($conn, $categoryquery);
    if (!$insert) {
      $msg = "FAiled to insert";
    }
    $msg = "Created";
    header("Location:EditItemPage.php");
  } else {
    $msg = "Failed";
  }
  ?>
  
  <?php
  //select all from category
  $catesql = "SELECT * FROM category";
  $cresult = mysqli_query($conn, $catesql);
  $categories = mysqli_fetch_all($cresult, MYSQLI_ASSOC);


  ?>
  <?php
  if (isset($_REQUEST['deletecate_id'])) {
    // select image from db to delete
    $id = $_REQUEST['deletecate_id'];  //get delete_id and store in $id variable

    $select_stmt = $db->prepare('SELECT * FROM category WHERE cate_id =:id');  //sql select query
    $select_stmt->bindParam(':id', $id);
    $select_stmt->execute();


    //delete an orignal record from db
    $delete_stmt = $db->prepare('DELETE FROM category WHERE cate_id =:id');
    $delete_stmt->bindParam(':id', $id);
    $delete_stmt->execute();

    header("Location:EditItemPage.php");
  }



  ?>
  <?php
//add shipping method
  if (isset($_POST['s_submit'])) {
    $shippingmethod = $_POST['txt_shipping'];
    $shippingquery = "INSERT INTO shipping(s_method) VALUES ('$shippingmethod')";
    $msg = "";
    $insert =  mysqli_query($conn, $shippingquery);
    if (!$insert) {
      $msg = "FAiled to insert";
    }
    $msg = "Created";
    header("Location:EditItemPage.php");
  } else {
    $msg = "Failed";
  }

//select all from shipping
  $shipsql = "SELECT * FROM shipping";
  $sresult = mysqli_query($conn, $shipsql);
  $s_shipping = mysqli_fetch_all($sresult, MYSQLI_ASSOC);



//delete shipping method that selected by user
  if (isset($_REQUEST['deleteship_id'])) {

    $id = $_REQUEST['deleteship_id'];

    $select_stmt = $db->prepare('SELECT * FROM shipping WHERE s_id  =:id');  //sql select query
    $select_stmt->bindParam(':id', $id);
    $select_stmt->execute();


    $delete_stmt = $db->prepare('DELETE FROM shipping WHERE s_id  =:id');
    $delete_stmt->bindParam(':id', $id);
    $delete_stmt->execute();

    header("Location:EditItemPage.php");
  }
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



  <?php


  if (isset($_REQUEST['dlt_id'])) {
    // select image from db to delete
    $id = $_REQUEST['dlt_id'];  //get delete_id and store in $id variable
    $cstatus = "delete";
    $select_stmt = $db->prepare('SELECT * FROM productmain2 WHERE p_id =:id');  //sql select query
    $select_stmt->bindParam(':id', $id);
    $select_stmt->execute();
    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
    unlink("Images/" . $row['image']); //unlink function permanently remove your file

    //delete an orignal record from db
    $delete_stmt = $db->prepare('UPDATE productmain2 SET p_status=:cstatus WHERE p_id =:id');
    $delete_stmt->bindParam(':id', $id);
    $delete_stmt->bindParam(':cstatus', $cstatus);
    $delete_stmt->execute();

    header("Location:EditItemPage.php");
  }

  ?>
  <?php


  if (isset($_REQUEST['act_id'])) {
   
    $id = $_REQUEST['act_id'];  //get delete_id and store in $id variable
    $cstatus = "active";
    $select_stmt = $db->prepare('SELECT * FROM productmain2 WHERE p_id =:id');  //sql select query
    $select_stmt->bindParam(':id', $id);
    $select_stmt->execute();
    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
    unlink("Images/" . $row['image']); //unlink function permanently remove your file

    //delete an orignal record from db
    $delete_stmt = $db->prepare('UPDATE productmain2 SET p_status=:cstatus WHERE p_id =:id');
    $delete_stmt->bindParam(':id', $id);
    $delete_stmt->bindParam(':cstatus', $cstatus);
    $delete_stmt->execute();

    header("Location:EditItemPage.php");
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
<link rel="stylesheet" href="Externalstylesheet/style3.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
  <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- google font-->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Glory:wght@500&display=swap" rel="stylesheet">
  <!-- google font-->


</head>
<style>
  * {
    font-family: 'Glory', sans-serif;
  }

  h2 {
    background-color: white;
    font-family: 'Titillium Web', sans-serif;


  }

  .category {
    float: left;
    width: 45%;


    margin: 10px;

  }

  td {
    text-align: center;
    text-overflow: ellipsis;
  }


  .category td {
    text-align: center;
    width: 50%;
  }

  .shipping {
    float: right;
    width: 45%;
    margin: 10px;

  }

  .shipping th,
  .category th {
    text-align: center;
    background-color: #3E2C41;

    border-top-left-radius: 20px;
    border-top-right-radius: 20px;

    box-shadow: 0px 0px 4px black;


  }

  .shipping td,
  .category td {
    text-align: center;
    width: 50%;
    border: 1px solid #ddd;


  }

  .producttable th {
    text-align: center;
    background-color: #3E2C41;
    font-family: 'Titillium Web', sans-serif;



  }

  hr {
    color: black;
  }

  a {
    text-decoration: none;
  }

  .user {
    display: none;
  }

  .admin {
    display: block;
  }


  @media only screen and (min-width: 700px) {


    .go {
      max-width: 35%;

    }
  }


  @media only screen and (min-width: 1024px) {


    .go {
      max-width: 15%;

    }
  }

  .NoItemNotification {
    background-color: #6E85B2;
    margin: 10% 25%;
    color: blanchedalmond;
    padding: 150px;
    border-radius: 30px;
    box-shadow: 0px 0px 7px #6E85B2;
    font-size: 20px;
    font-family: 'Glory', sans-serif;
    ;
   
  }
  .NoItemNotification a{
 text-decoration: underline;
   
  }
  .NoItemNotification a:hover,.NoItemNotification svg:hover{
    text-shadow: 0px 0px 5px blanchedalmond;
  color: blanchedalmond;
  
  }
 
 td .des{
  display: inline-block;
  overflow: hidden;
  white-space: nowrap;
  text-overflow: ellipsis; 
    width:100px;
    height: auto;
  }
 

</style>

<body>

  <?php
  include "Php/header.php";
  ?>
  
  <?php
  include "Php/sidebar.php";
  ?>


  <div class="w3">
    <button id="openNav" class="w3-button w3-black w3-xlarge" style="border-radius: 50px; margin: 5px 5px;" onclick="w3_open()">&#9776;</button>
  </div>
  </div>

  <div id="main">
    <center>
      <div class="w3-container">


      </div>

      <form action="#" method="post">
        <input class="go" type="text" name="go" PLACEHOLDER="Search Order ID...">
        <input class="btn btn-primary search" type="submit" id="searchoid" name="searchoid" value="search">
      </form>


      <hr>


      <?php
if($_SESSION['userrole'] == "user" ){
      $sql = "SELECT * FROM productmain2 WHERE user_email= '" . $_SESSION['user_email'] . "'";
      $result = $conn->query($sql);

      if (isset($_POST['searchoid'])) {

        $go = $_POST['go'];

        $sql = "SELECT * FROM productmain2 WHERE user_email= '" . $_SESSION['user_email'] . "' AND  p_id = '$go';  ";
        $result = $conn->query($sql);

        if ($go == "") {

          $sql = "SELECT * FROM productmain2 WHERE user_email= '" . $_SESSION['user_email'] . "'";
          $result = $conn->query($sql);
        }
      }
    }else{

      $sql = "SELECT * FROM productmain2";
      $result = $conn->query($sql);

      if (isset($_POST['searchoid'])) {

        $go = $_POST['go'];

        $sql = "SELECT * FROM productmain2 WHERE p_id = '$go';";
        $result = $conn->query($sql);

        if ($go == "") {

          $sql = "SELECT * FROM productmain2";
          $result = $conn->query($sql);
        }
      }


    }






      if ($result->num_rows > 0) { ?>
        <div class="producttable">
          <table>
            <tr>
              <th>Product ID</th>
              <th>Email</th>
              <th>Contact No</th>
              <th>Description</th>
              <th>Stock</th>
              <th>Product Name</th>
              <th>Condition</th>
              <th>Price</th>
              <th>Shipping Method</th>
              <th>Category</th>
              <th>Product Images</th>
              <th>Status</th>
              <th>Edit Item</th>
              <th>Active Item</th>
              <th>Delete Item</th>
            </tr>

        </div>

        <?php

        while ($row = $result->fetch_assoc()) {
          $productID = $row['p_id'];
          $pemail = $row['user_email'];
          $contactNo = $row['user_phone'];
          $des = $row['p_des'];
          $quantity = $row['p_quantity'];
          $pname = $row['p_name'];
          $pcondition = $row['p_condition'];
          $price = $row['p_price'];
          $pstatus = $row['p_status'];
          $shipping = $row['p_shipping'];
          $category = $row['p_category'];
          $images = $row['p_image'];

        ?>


          <tr>
            <td style="border-left:1px solid #ddd;   padding: 8px;
   text-align: left; color: blanchedalmond;font-family: 'Titillium Web', sans-serif;text-align:center;">
              <?php echo  $productID; ?></td>
            <td><?php echo  $pemail; ?></td>
            <td><?php echo  $contactNo; ?></td>
            <td> <div class="des"> <?php echo  $des; ?></div></td>
            <td><?php echo  $quantity; ?></td>
            <td><?php echo  $pname; ?></td>
            <td><?php echo  $pcondition; ?></td>
            <td>RM<?php echo  $price; ?></td>
            <td><?php echo  $shipping; ?></td>
            <td><?php echo  $category; ?></td>
            <td> <img src="Images/<?php echo  $images; ?>" alt=""> </td>
            <td>
              <?php echo  $pstatus; ?>
            </td>
            <td>
              <button id="editButton" class="btn btn-outline-info">
                <a id="hide" href="EditProcess.php?update_id=<?php echo $productID ?>">Edit</a>
              </button>
            </td>
            <td><button class="btn btn-outline-success"><a href="?act_id=<?php echo $productID ?>">Active</a></button></td>
            <td style="border-right:1px solid #ddd;   padding: 8px;
   text-align: left;color: blanchedalmond;font-family: 'Titillium Web', sans-serif;"><button runat="server" class="btn btn-outline-danger"><a onclick="return confirm('Are you sure you want to delete this item?')" href="?dlt_id=<?php echo $productID ?>">Delete</a></button></td>
          </tr>

        <?php } ?>
        </table>
      <?php

      } else {  ?>
 <!-- If there is no records, then show this -->
        <div class="NoItemNotification">
          You haven't sell anything yet <br>&#x1F62F;<br>
          <a href="AddItemPage.php">
            Wanna sell some? <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
  <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
</svg>
          </a>
        </div>
      <?php  } ?>





  </div>
        <!-- if user role is admin display this -->
  <div class="<?php echo $_SESSION['userrole']; ?>">
    <hr style="width:100%;">
    <div style="margin: auto 15%;">
    <div class="category">
      <form action="" method="POST">
        <table>

          <th colspan="2">
            Category

          </th>
          <?php foreach ($categories as $category) : ?>
            <tr>
              <td>

                <?php echo $category['CategoryTitle']; ?>
              </td>
              <td>
                <button type="button" name="delete<?php echo $category['cate_id']; ?>" class="btn btn-outline-danger"> <a style="text-decoration: none;" href="?deletecate_id= <?php echo $category['cate_id']; ?>">
                    delete</a>
                </button>
              </td>
            </tr>
          <?php endforeach; ?>

          <tr>

          </tr>

          <tr>
            <td>
              <input style="background-color: transparent;border:4px solid transparent;
                  
                        border-bottom:1px solid black;
                      
                        color:blanchedalmond;
                        " type="text" name="txt_category" placeholder="Add a category.....">

            </td>
            <td> <button type="submit" class="btn btn-outline-success" name="submit">Add</button></td>
          </tr>
        </table>

    </div>
    </form>

    <div class="vl"></div>



    <div class="shipping">
      <form action="" method="POST">
        <table>

          <th colspan="2">
            Shipping Method

          </th>
          <?php foreach ($s_shipping as $ship) : ?>
            <tr>
              <td>

                <?php echo $ship['s_method']; ?>
              </td>
              <td>
                <button type="button" class="btn btn-outline-danger"> <a style="text-decoration: none;" href="?deleteship_id= <?php echo $ship['s_id']; ?>">
                    delete</a>
                </button>
              </td>
            </tr>
          <?php endforeach; ?>
          <tr>
          </tr>
          <tr>
            <td>
              <input style="background-color: transparent;border:4px solid transparent;
                        border-bottom:1px solid black;
                      
                        color:blanchedalmond;
                        " type="text" name="txt_shipping" placeholder="Add shipping method.....">
            </td>
            <td> <button type="submit" class="btn btn-outline-success" name="s_submit">Add</button></td>
          </tr>
        </table>
    </div>
  </div>
  </form>

  </div>



  </div>
  </div>
</body>
<script src="JS/sidebarbutton.js"></script>

</html>
<script>


</script>