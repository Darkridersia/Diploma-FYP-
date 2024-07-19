<?php
session_start();

// if user didnt login, bring them to login page
if (!isset($_SESSION['user_email'])) {
    header("Location:login.php");
}


include_once "Php/config.php";
include_once "Php/validation.php";
// Select user's cart
$sql = "SELECT * FROM addtocart WHERE cart_user_email = '" . $_SESSION['user_email'] . "'";
$result = mysqli_query($conn, $sql);
$carts = mysqli_fetch_all($result, MYSQLI_ASSOC);
$sql = "SELECT * FROM users WHERE user_email = '" . $_SESSION['user_email'] . "'";

$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_array($result)) {
    $email =  $row['user_email'];
    $password =  $row['user_password'];
    $contact_no =  $row['user_contact'];
    $profileimg =  $row['profile_img'];
}
?>

<?php
$sql3 = "SELECT * FROM category";
$result3 = mysqli_query($conn, $sql3);
$categories = mysqli_fetch_all($result3, MYSQLI_ASSOC);

$sql = "SELECT * FROM productmain2";
$result = mysqli_query($conn, $sql);
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);





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


foreach ($carts as $cart) :
    $cart['product_name'];
endforeach;

if (!isset($cart['product_name'])) {
    header("Location:index.php");
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

    h1 {
        color: blanchedalmond;
        font-family: 'Glory', sans-serif;
    }




    .custom-control-label {
       
        cursor: initial;

        color: blanchedalmond;

        font-family: 'Glory', sans-serif;


    }

    #creditcardpayment {

      
        font-family: 'Glory', sans-serif;

        color: blanchedalmond;

    }

    i {
        font-family: 'Glory', sans-serif;
        color: red;
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
    <div style="max-width: 1100px;margin:auto;">
        <div class="row">
            <div class="col-sm-4">
                <div style="height:100px;margin:10px;" class="cartdetails">

                    <table>

                        <tr>
                            <th>Your Cart</th>
                            <th>qty</th>
                            <th>price</th>
                        </tr>
                        <?php $sum = 0 ?>
                        <?php foreach ($products as $product) : ?>
                            <?php
                            $product['p_quantity'];
                            ?>
                        <?php endforeach; ?>
                        <tr>
                            <?php foreach ($carts as $cart) :  ?>


                                <td> <?php echo $cart['product_name'] ?> </td>
                                <td><?php echo $cart['quantity'] ?></td>
                                <td>RM <?php echo $cart['total_price'] ?></td>
                                <?php
                                
                                $sum += $cart['total_price'];
                                ?>
                        </tr>


                    <?php endforeach; ?>

                    <td>Total Price</td>
                    <td></td>
                    <td><strong>RM <?php echo number_format($sum, 2); ?></strong> </td>
                    <tr>

                    </tr>


                    </table>

                </div>
            </div>

      

            <div class="col-sm-7">
                <div style="background-color:#2C394B;border-radius:20px;height:auto; margin-top:20px;padding:20px;" class="creditInformation">

                    <h1>Billing details</h1>
                    <hr>
<div id="cashpayment">
    <!-- cash payment part -->
<?php
include "Php/checkoutbtnprocess.php";

            ?>
                    <div class="row">
                        <div class="col-6">
                            <form action="" method="POST" enctype="multipart/form-data">
                                <div style="display: none;">


                                </div>
                                <input style="width:100%;" type="text" placeholder="First Name" name="txt_fname" id="txt_fname" value="<?php echo (isset($Fname) && !empty($Fname)) ? $Fname : '' ?>">
                                <i style="margin: 0px;"><?php echo $fnameerrormsg ?></i>

                        </div>
                        <div class="col-6">
                            <input style="width:100%;" type="text" placeholder="Last Name" name="txt_lname" id="txt_lname" value="<?php echo (isset($Lname) && !empty($Lname)) ? $Lname : '' ?>">
                            <i><?php echo $lnameerrormsg ?></i>
                        </div>
                        <br>
                        <br>

                        <div class="col-6">
                            <input style="width:100%;" type="text" placeholder="Contact Number" name="txt_buyercno" id="txt_buyercno" value="<?php echo (isset($buyerCno) && !empty($buyerCno)) ? $buyerCno :  $contact_no ?>">
                            <i><?php echo $cnoerrormsg ?></i>
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col-12">
                            <input style="width:100%;" type="text" placeholder="Address" name="txt_address" id="txt_address" value="<?php echo (isset($address1) && !empty($address1)) ? $address1 : '' ?>">
                            <i><?php echo $addresserrormsg ?></i>
                        </div>
                        <br>
                        <br>
                        <div class="col-12">
                            <input style="width:100%;" type="text" placeholder="Address 2(Optional)" name="txt_address2" id="txt_address2" value="<?php echo (isset($address2) && !empty($address2)) ? $address2 : '' ?>">

                        </div>
                        <br>
                        <br>
                        <div class="col-3">
                            <input maxlength="5" style="width:100%;" type="text" placeholder="Zip code" name="txt_zip" id="txt_zip" value="<?php echo (isset($zipcode) && !empty($zipcode)) ? $zipcode : '' ?>">
                            <i><?php echo $ziperrormsg ?></i>
                        </div>
                        <br>
                        <br>
                        <div class="row">
                            <div class="col-3">
                                <input style="width:100%;" type="text" placeholder="City" name="txt_city" id="txt_city" value="<?php echo (isset($city) && !empty($city)) ? $city : '' ?>">
                                <i><?php echo $cityerrormsg ?></i>
                            </div>
                            <br>
                            <br>
                            <div class="col-3">
                                <input style="width:100%;" type="text" placeholder="State" name="txt_state" id="txt_state" value="<?php echo (isset($state) && !empty($state)) ? $state : '' ?>">
                                <i><?php echo $stateerrormsg ?></i>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h1>Payment Method</h1>
                            <hr>
                        </div>
                        <div class="col-6">

                            <input style="width: 15%;margin-right:0px;" type="radio" id="cash" name="payment" value="Cash On Delivery" checked>
                            <label class="custom-control-label" for="paymentmethod1">Cash on delivery</label>

                        </div>
                        <div class="col-6">
                            <input style="width: 15%;margin-right:0px;" type="radio" id="credit" name="payment" value="Credit/Debit Card">
                            <label class="custom-control-label" for="paymentmethod2">Credit card</label>

                        </div>
                    </div>
                    <div style="display: none;">
                        <div class="col-6">
                            <input type="email" placeholder="Email" name="txt_email" id="txt_email" value="<?php echo (isset($buyeremail) && !empty($buyeremail)) ? $buyeremail : $_SESSION['user_email'] ?>">
                            <i><?php echo $emailerrormsg ?></i>
                        </div>
                    </div>

                    <br>
                    <div id="cashpayment">
                        
                        <button style="width:80%;" type="submit" name="checkout" id="checkout" class="btn btn-primary">Continue To Check Out</button>
                       
                    </div>
                    </form>
                    </div>
                    <div style="display: none;" id="creditcardpayment">
  <!-- credit card payment -->
                    <div class="row">
                        <div class="col-6">
                            <form action="" method="POST" enctype="multipart/form-data">
                                <div style="display: none;">


                                </div>
                                <input style="width:100%;" type="text" placeholder="First Name" name="txt_fname" id="txt_fname" value="<?php echo (isset($Fname) && !empty($Fname)) ? $Fname : '' ?>">
                                <i style="margin: 0px;"><?php echo $fnameerrormsg ?></i>

                        </div>
                        <div class="col-6">
                            <input style="width:100%;" type="text" placeholder="Last Name" name="txt_lname" id="txt_lname" value="<?php echo (isset($Lname) && !empty($Lname)) ? $Lname : '' ?>">
                            <i><?php echo $lnameerrormsg ?></i>
                        </div>
                        <br>
                        <br>

                        <div class="col-6">
                            <input style="width:100%;" type="text" placeholder="Contact Number" name="txt_buyercno" id="txt_buyercno" value="<?php echo (isset($buyerCno) && !empty($buyerCno)) ? $buyerCno :  $contact_no ?>">
                            <i><?php echo $cnoerrormsg ?></i>
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col-12">
                            <input style="width:100%;" type="text" placeholder="Address" name="txt_address" id="txt_address" value="<?php echo (isset($address1) && !empty($address1)) ? $address1 : '' ?>">
                            <i><?php echo $addresserrormsg ?></i>
                        </div>
                        <br>
                        <br>
                        <div class="col-12">
                            <input style="width:100%;" type="text" placeholder="Address 2(Optional)" name="txt_address2" id="txt_address2" value="<?php echo (isset($address2) && !empty($address2)) ? $address2 : '' ?>">

                        </div>
                        <br>
                        <br>
                        <div class="col-3">
                            <input maxlength="5" style="width:100%;" type="text" placeholder="Zip code" name="txt_zip" id="txt_zip" value="<?php echo (isset($zipcode) && !empty($zipcode)) ? $zipcode : '' ?>">
                            <i><?php echo $ziperrormsg ?></i>
                        </div>
                        <br>
                        <br>
                        <div class="row">
                            <div class="col-3">
                                <input style="width:100%;" type="text" placeholder="City" name="txt_city" id="txt_city" value="<?php echo (isset($city) && !empty($city)) ? $city : '' ?>">
                                <i><?php echo $cityerrormsg ?></i>
                            </div>
                            <br>
                            <br>
                            <div class="col-3">
                                <input style="width:100%;" type="text" placeholder="State" name="txt_state" id="txt_state" value="<?php echo (isset($state) && !empty($state)) ? $state : '' ?>">
                                <i><?php echo $stateerrormsg ?></i>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h1>Payment Method</h1>
                            <hr>
                        </div>
                        <div class="col-6">

                            <input style="width: 15%;margin-right:0px;" type="radio" id="cash" name="payment" value="Cash On Delivery" checked>
                            <label class="custom-control-label" for="paymentmethod1">Cash on delivery</label>

                        </div>
                        <div class="col-6">
                            <input style="width: 15%;margin-right:0px;" type="radio" id="credit" name="payment" value="Credit/Debit Card">
                            <label class="custom-control-label" for="paymentmethod2">Credit card</label>

                        </div>
                    </div>
                    <div style="display: none;">
                        <div class="col-6">
                            <input type="email" placeholder="Email" name="txt_email" id="txt_email" value="<?php echo (isset($buyeremail) && !empty($buyeremail)) ? $buyeremail : $_SESSION['user_email'] ?>">
                            <i><?php echo $emailerrormsg ?></i>
                        </div>
                    </div>
                            <table class="creditcardtable">
                                <tr>
                                    <th>
                                        <label for="cardname">Name On Card:</label>
                                    </th>
                                    <td><input type="text" id="cardname" name="cardname" placeholder="CIMB" required></td>
                                    <th> <label for="cardtype">Card Type:</label> </th>
                                    <td><select id="cardtype" name="cardtype" required> 
                                    <option disabled selected value> -- SELECT A CARD -- </option>
                                    <option value="VISA">VISA</option>
                                    <option value="MASTER">MASTER</option>
                                </select>
                                </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="cardno">Card No:</label>
                                    </th>
                                    <td colspan="5"> <input style="width:100%;" type="text" id="cardno" name="cardno" placeholder="xxxx xxxx xxxx xxxx" required maxlength="16" minlength="16"></td>
                                </tr>
                                <tr>
                                <tr>
                                    <th>
                                        <label for="expire">Expire Date:</label>
                                    </th>
                                    <td>
                                        <input maxlength="5" type="text" id="expire" name="expire" placeholder="06/25" required>
                                    </td>

                                    <th> <label for="cvv">CVV:</label></th>
                                    <td> <input type="text" id="cvv" maxlength="3" name="cvv" placeholder="3 digit behind the card" required minlength="3"></td>
                                </tr>



                            </table>
                            <br>
                            <br>
                            <button style="width:80%;" type="submit" name="creditcardcheck" id="creditcardcheck" class="btn btn-primary">Continue To Check Out</button>
                            </form>
                    </div>
                   

                   <?php include_once "server.php"; ?>

                   






                </div>
            </div>
        </div>

        <script src="JS/payment.js"></script>
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
            
            setInputFilter(document.getElementById('cardname'), function(value) {

return/^[a-z]*$/i.test(value); });

            setInputFilter(document.getElementById('txt_zip'), function(value) {

return /^-?\d*$/.test(value);
}

);
            setInputFilter(document.getElementById('txt_zip'), function(value) {

                    return /^-?\d*$/.test(value);
                }

            );
            setInputFilter(document.getElementById('txt_buyercno'), function(value) {

                    return /^-?\d*$/.test(value);
                }

            );
            setInputFilter(document.getElementById('cvv'), function(value) {

                    return /^-?\d*$/.test(value);
                }

            );
            setInputFilter(document.getElementById('cardno'), function(value) {

                    return /^-?\d*$/.test(value);
                }
                

            );
            setInputFilter(document.getElementById('expire'), function(value) {

return /^-?\d*[/]?\d{0,2}$/.test(value);
}


);
           
        </script>