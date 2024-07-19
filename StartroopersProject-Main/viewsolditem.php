<?php
session_start();
if (!isset($_SESSION['user_email'])) {
        // if user didnt login, bring them to login page
    header("Location:login.php");
}
$bid = $_REQUEST['batchid'];
include_once "Php/config.php";
include_once "Php/connection.php";
$psql = "SELECT * FROM itemhistory WHERE batch_id = $bid;";
$presult = mysqli_query($conn, $psql);
$phistories = mysqli_fetch_all($presult, MYSQLI_ASSOC);
foreach ($phistories as $phistory) :
    $productid = $phistory['product_ID'];
endforeach;


?>
<?php
$sql = "SELECT * FROM productmain2 WHERE p_id = $productid;";
$result = mysqli_query($conn, $sql);
$product = mysqli_fetch_all($result, MYSQLI_ASSOC);



?>
<?php
$sql3 = "SELECT * FROM category";
$result3 = mysqli_query($conn, $sql3);
$categories = mysqli_fetch_all($result3, MYSQLI_ASSOC);



?>
<?php

if (isset($_REQUEST['shipped'])) {
    $status = "Shipped";
    $id = $oid;

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


    img {
        width: 25%;
        height: 15%;
        margin: 10px 240px;
        box-shadow: 0px 0px 10px black;
    }

    .itemshowcase {
        padding: 30px;
        background-color: #3C415C;
        border-radius: 20px;
        box-shadow: 0px 0px 4px black;
        width: 700px;
        max-width: 700px;

        margin: auto;
        height: auto;
        color: blanchedalmond;
        font-family: 'Titillium Web', sans-serif;
        font-size: 20px;
        margin-top: 7px;


    }

    .itemshowcase label {
        padding-left: 10px;
        margin: 5px;


    }
</style>

<body>

    <?php
    include "Php/header.php";
    ?>
    <br>

    <div id="main">
        <center>
            <div class="w3-container">

            </div>
        </center>
        <div class="w3-container">
            <div class="itemshowcase">
                <?php $totalprice = 0; ?>
                <?php foreach ($phistories as $phistory) :  ?>

                    <img src="Images/<?php echo $phistory['itemimage']; ?>" alt="">

                    <div class="row">
                        <div class="col-3">
                            <br>

                            <label for="">Delivery address :
                                <?php echo $phistory['address']; ?>
                                <?php echo $phistory['address2']; ?>,
                                <?php echo $phistory['zip']; ?>,
                                <?php echo $phistory['country']; ?>,
                                <?php echo $phistory['state']; ?>
                            </label>
                        </div>
                    </div>

                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <label for="">Order ID : <?php echo $phistory['order_id']; ?></label>
                            <?php $oid = $phistory['order_id'] ?>
                            <br>
                            <label for="">ProductID : <?php echo $phistory['product_ID']; ?></label>
                            <br>
                             <!-- redirect you to a page that will send a email to buyerr -->
                            <label for="">Buyer Email : <a href="askorderfill.php?order_id=<?php echo $oid ?>&view=sold&batchid=<?php echo $bid ?>">

                                    <?php echo $phistory['buyer_email']; ?></a></label>
                            <br>
                                   <!-- whatsapp API, redirect user to whatsapp page and pre filled message in the chatbox that ready to send to buyer -->
                            <label for="">Buyer Contact No : <a target="_blank" href="https://api.whatsapp.com/send?phone=6<?php echo $phistory['buyerCno']; ?>&text=Did%20you%20received%20the%20item?%20<?php echo "Order ID : $oid" ?>"><?php echo $phistory['buyerCno']; ?></a></label>
                            <br>
                            <label for="">Order Date : <?php echo $phistory['Date']; ?></label>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <?php foreach ($product as $products) :  ?>
                                <label style="float: right;" for="">Product price : RM<?php echo number_format($products['p_price'], 2); ?></label>
                        </div>
                    </div>
                <?php endforeach; ?>
                <br>
                <div class="row">
                    <div class="col-12">
                        <label style="float: right;" for="">Quantity : <?php echo $phistory['Product_quantity']; ?></label>

                    </div>
                </div>
                <?php

                    $totalprice += $phistory['Price']; ?>
                <hr>
            <?php endforeach; ?>

            <div class="row">
                <div class="col-12">
                    <label style="float: right;" for=""> <strong>Total price = RM<?php echo number_format($totalprice, 2); ?></strong></label>
                    <br>

                </div>
            </div>
            <hr>

 



        </div>
</body>
<script src="JS/sidebarbutton.js"></script>

</html>