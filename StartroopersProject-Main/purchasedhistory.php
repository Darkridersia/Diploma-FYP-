<?php
session_start();
if (!isset($_SESSION['user_email'])) {
     // if user didnt login, bring them to login page
    header("Location:login.php");
}
include_once "Php/config.php";
include_once "Php/connection.php";
// if user login as "user", show only user's item
if($_SESSION['userrole'] == "user" ){
$psql = "SELECT * FROM itemhistory WHERE buyer_email = '" . $_SESSION['user_email'] . "'";
$presult = mysqli_query($conn, $psql);
$presultrow = mysqli_num_rows($presult);
$phistories = mysqli_fetch_all($presult, MYSQLI_ASSOC);
}else{
    // if user is a admin, show all item
    $psql = "SELECT * FROM itemhistory";
    $presult = mysqli_query($conn, $psql);
    $presultrow = mysqli_num_rows($presult);
    $phistories = mysqli_fetch_all($presult, MYSQLI_ASSOC);

}
$sql3 = "SELECT * FROM category";
$result3 = mysqli_query($conn, $sql3);
$categories = mysqli_fetch_all($result3, MYSQLI_ASSOC);

//search item id
if (isset($_POST['searchid'])) {

    $went = $_POST['went'];

    $sql = "SELECT * FROM itemhistory WHERE buyer_email = '" . $_SESSION['user_email'] . "' AND  order_id = '$went';  ";

    $result = mysqli_query($conn, $sql);

    $phistories = mysqli_fetch_all($result, MYSQLI_ASSOC);

    if ($went == "") {
        $sql = "SELECT * FROM itemhistory WHERE buyer_email = '" . $_SESSION['user_email'] . "'";
        $result = mysqli_query($conn, $sql);
        $phistories = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
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

    table {
        max-width: 100%;
        margin: auto;
    }


    .purchaseditem {
        margin: auto;
        width: 60%;



    }

    .purchaseditem th {
        text-align: center;
        background-color: #3E2C41;
        font-family: 'Titillium Web', sans-serif;
        border-top-left-radius: 20px;
        border-top-right-radius: 20px;
        box-shadow: 0px 0px 4px black;


    }

    .purchaseditem td {
        text-align: center;
        width: 10%;
  height: 1%;
        border: 1px solid #ddd;


    }

    .w3-container {
        width: 100%;

    }

    .purchaseditem td a:hover ,.purchaseditem td button:hover{
        color: blanchedalmond;
    }

    th {
        font-size: 25px;
    }





    .center {
        text-align: center;
        margin: 10px;
    }


    @media only screen and (min-width: 700px) {


        .went {
            max-width: 35%;

        }
    }

    /*  Need to transfer this to new project */
    @media only screen and (min-width: 1024px) {


        .went {
            max-width: 15%;

        }
    }
    .NoItemNotification {
    background-color: #6E85B2;
    margin: 5% 10%;
    color: blanchedalmond;
    padding: 150px;
    border-radius: 30px;
    box-shadow: 0px 0px 7px #6E85B2;
    font-size: 20px;
    font-family: 'Glory', sans-serif;
    ;
   text-align: center;
  }
  .NoItemNotification a{
 text-decoration: underline;
   
  }
  .NoItemNotification a:hover,.NoItemNotification svg:hover{
    text-shadow: 0px 0px 5px blanchedalmond;
  color: blanchedalmond;
  
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
        </center>
        <div class="w3-container">
            <div class="purchaseditem">

                <!-- This div class center is to postion the input and button to center -->
                <div class="center">
                    <form action="#" method="post">
                        <input class="went" type="text" name="went" placeholder="search order ID...">

                        <input class="btn btn-primary search" PLACEHOLDER="First Name" type="submit" id="search" name="searchid" value="search">
                    </form>
                </div>
<?php if($presultrow > 0) { ?>
                <table>
                    <tr>
                        <th colspan="10">
                            Purchased Item

                        </th>
                    </tr>
                    <tr>
                        <td>

                            Order ID
                        </td>
                        <td>
                            Item Pic
                        </td>
                        <td>
                            Qty
                        </td>
                        <td>
                            Total price
                        </td>
                        <td>
                            Shipping Method
                        </td>
                        <td>
                            Payment Method
                        </td>
                        <td>
                            Item Status
                        </td>
                        <td>

                        </td>
                        <td>

                        </td>
                        <td>

                        </td>
                    </tr>

                    <?php foreach ($phistories as $phistory) : ?>
                        <tr>
                            <td>
                                <?php $orderid = $phistory['order_id']; ?>
                                <?php echo $phistory['order_id'];  ?>

                            </td>
                            <td>
                            <div style="height: 50px;width:50px;margin:auto;overflow:hidden;">
                                <img style="height: 100%;width:100%;" src="Images/<?php echo $phistory['itemimage']; ?>" alt="images.jpg">
                            </div>
                            </td>
                            <td>
                                <?php echo $phistory['Product_quantity'];  ?>
                            </td>
                            <td>
                                RM<?php echo number_format($phistory['Price'], 2);  ?>
                            </td>
                            <td>
                                <?php echo $phistory['shipping'];  ?>
                            </td>
                            <td>
                                <?php echo $phistory['paymentmethod'];  ?>
                            </td>
                            <td>
                                <?php echo $phistory['Status'];  ?>
                            </td>
                            <td>

                                <!--<a class="btn btn-dark" name="cancel" id="cancel"  <?php if ($phistory['Status'] == 'Cancelled Order') { ?> disabled <?php   } ?> href="cancel.php?orderid=<?php echo $phistory['order_id']; ?>">
                            Cancel Order
                            </a>
                            -->

                                <?php
                                // Use OR or || also can
                            //   if status is cancelled, shipped, received, display alert box 
                                if ($phistory['Status'] == 'Payment comfirmed') { ?>

                                    <a class="btn btn-danger" name="cancel" id="cancel" href="cancel.php?orderid=<?php echo $phistory['order_id']; ?>&product_quantity=<?php echo $phistory['Product_quantity']; ?>&product_id=<?php echo $phistory['product_ID']; ?>"> Cancel Order</a>


                                <?php } elseif ($phistory['Status'] == 'Cancelled Order') { ?>

                                    <a class="btn btn-secondary" name="cancel" id="cancel" href="#" onclick="alert('This order is already Cancelled!')"> Cancel Order</a>

                                <?php } elseif ($phistory['Status'] == 'Shipped') { ?>

                                    <a class="btn btn-secondary" name="cancel" id="cancel" href="#" onclick="alert('This order is already Shipped!')"> Cancel Order</a>


                                <?php } elseif ($phistory['Status'] == 'Item Received') { ?>

                                    <a class="btn btn-secondary" name="cancel" id="cancel" href="#" onclick="alert('This item is received!')"> Cancel Order</a>

                                <?php } ?>


                            </td>
                            <td>
                                <form method="POST">
                                    <div style="display: none;">
 <!-- if status is cancelled, shipped, received, display alert box -->
                                        <input type="text" name="oid" id="oid" value="<?php echo $orderid ?>">

                                    </div>
                                    <?php if ($phistory['Status'] == 'Cancelled Order') { ?>

                                        <button onclick="alert('This order is already Cancelled!')" class="btn btn-success">
                                            Item Received
                                        </button>



                                    <?php } elseif ($phistory['Status'] == 'Item Received') { ?>

                                        <button onclick="alert('This item is received!')" class="btn btn-success">
                                            Item Received
                                        </button>



                                    <?php } else { ?>

                                        <button name="received<?php echo $orderid ?>" class="btn btn-success">
                                            Item Received
                                        </button>


                                    <?php } ?>
                                </form>
                            </td>
                            <td>
                                <a class="btn btn-dark" href="viewpurchaseditem.php?batchid=<?php echo $phistory['batch_id']; ?>">
                                    View Details
                                </a>
                            </td>
                        </tr>

                        </tr>
                        <?php
                          //set status to cancel
                        if (isset($_REQUEST['cancel' . $orderid])) {
                            $status = "Shipped";
                            $id = $_REQUEST['oid'];

                            $select_stmt = $db->prepare('SELECT * FROM itemhistory WHERE order_id =:id');  //sql select query
                            $select_stmt->bindParam(':id', $id);
                            $select_stmt->execute();


                            //delete an orignal record from db
                            $update_stmt = $db->prepare('UPDATE itemhistory SET Status=:sstatus WHERE order_id=:id');
                            $update_stmt->bindParam(':id', $id);
                            $update_stmt->bindParam(':sstatus', $status);
                            $update_stmt->execute();

                            echo "<meta http-equiv='refresh' content='0;solditem.php'>";
                        }

                        ?>
                        <?php
                        //set status to item received 
                        if (isset($_REQUEST['received' . $orderid])) {
                            $status = "Item Received";
                            $id = $_REQUEST['oid'];

                            $select_stmt = $db->prepare('SELECT * FROM itemhistory WHERE order_id =:id');  //sql select query
                            $select_stmt->bindParam(':id', $id);
                            $select_stmt->execute();


                            //delete an orignal record from db
                            $update_stmt = $db->prepare('UPDATE itemhistory SET Status=:sstatus WHERE order_id=:id');
                            $update_stmt->bindParam(':id', $id);
                            $update_stmt->bindParam(':sstatus', $status);
                            $update_stmt->execute();

                            echo "<meta http-equiv='refresh' content='0;purchasedhistory.php'>";
                        }




                        ?>



                    <?php endforeach; ?>


                </table>
                <?php } else { ?>
 <!-- if row is equal to zero, show this -->
                    <div class="NoItemNotification">
          You haven't buy anything yet <br>&#x1F62F;<br>
       
          <a href="index.php">
           Go buy something! <svg style="margin-bottom:10px ;" xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
              <path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z" />
              <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
            </svg>
          </a>
        </div>



                    <?php } ?>
            </div>

        </div>
</body>
<script src="JS/sidebarbutton.js"></script>

</html>
<script>

function setInputFilter(textbox, inputFilter) {
                ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
                    textbox.addEventListener(event, function() {
                        if (inputFilter(this.value)) {
                            this.oldValue = this.value;
                            this.oldSelectionStart = this.selectionStart;
                            this.oldSelectionEnd = this.selectionEnd;
                        } else if (this.hasOwnProperty("oldValue")) {
                            this.value = this.oldValue;
                            this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                        } else {
                            this.value = "";
                        }
                    });
                });
            }
            

            setInputFilter(document.getElementById('went'), function(value) {

return /^-?\d*$/.test(value);
}

);

</script>