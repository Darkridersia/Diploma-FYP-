
<?php

$sql2 = "SELECT * FROM addtocart WHERE cart_user_email = '" .$_SESSION['user_email']."';";
  if ($result2 = mysqli_query($conn, $sql2)) {
    $rowcount = mysqli_num_rows($result2);
   
  }
  ?>
<a href="AddtoCart.php"> <i class="fa fa-shopping-cart" style="font-size: 65px; padding-top: 10px; padding-right: 35px; float: right;"> </i>
    <span class="cartnumber">
      <?php echo $rowcount;  ?>
    </span>
  </a>


<style>

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
</style>