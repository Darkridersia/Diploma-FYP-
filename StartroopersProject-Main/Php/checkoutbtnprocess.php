<?php
require_once "Php/PHPMailer/Exception.php";
require_once "Php/PHPMailer/PHPMailer.php";
require_once "Php/PHPMailer/SMTP.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
                $selectoid = "SELECT * FROM itemhistory ORDER BY order_id DESC LIMIT 1";
                $resultoid = mysqli_query($conn, $selectoid);
                $oidsearchrow = mysqli_num_rows($resultoid);

                if ($oidsearchrow == 0) {
                    $oid =  1;
                } else {

                    $oidrow = mysqli_fetch_all($resultoid, MYSQLI_ASSOC);
                    foreach ($oidrow as $oidrows) :
                        $order_id =  $oidrows['order_id'];
                    endforeach;
                    $oid =  $order_id + 1;
                }
                $fnameerrormsg = "";
                $lnameerrormsg = "";
                $emailerrormsg = "";
                $addresserrormsg = "";
                $ziperrormsg = "";
                $cityerrormsg = "";
                $stateerrormsg = "";
                $cnoerrormsg = "";
                require_once "Php/connection.php";
                $cartID = $cart['a_id'];
                try {
                    $id =  $cartID;
                    $select_stmt = $db->prepare('SELECT * FROM addtocart WHERE a_id =:id'); //sql select query
                    $select_stmt->bindParam(':id', $id);
                    $select_stmt->execute();
                    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
                    extract($row);
                } catch (PDOException $e) {
                    $e->getMessage();
                }

                if (isset($_POST['checkout'])) {
                    foreach ($carts as $cart) {
                        $pname  = $cart['product_name'];
                        $qty =  $cart['quantity'];
                        $pshipping  = $cart['shipping'];
                        $price = $cart['total_price'];
                        $selleremail = $cart['seller_email'];
                        $Pid = $cart['product_id'];
                        $sellerCno = $cart['seller_contactNo'];
                        $image_file1 = $cart['images'];


                        if (isset($_REQUEST['txt_fname'], $_REQUEST['txt_lname'], $_REQUEST['txt_email'], $_REQUEST['txt_address'], $_REQUEST['txt_zip'], $_REQUEST['txt_city'], $_REQUEST['txt_state'], $_REQUEST['txt_buyercno']) && !empty($_REQUEST['txt_fname']) && !empty($_REQUEST['txt_lname']) && !empty($_REQUEST['txt_email']) && !empty($_REQUEST['txt_address']) && !empty($_REQUEST['txt_zip']) && !empty($_REQUEST['txt_city']) && !empty($_REQUEST['txt_state']) && !empty($_REQUEST['txt_buyercno'])) {
                            $zipcode = validate_input($_REQUEST['txt_zip']);

                            if (strlen($zipcode) != 5) {

                                $Fname = validate_input($_REQUEST['txt_fname']);
                                $Lname = validate_input($_REQUEST['txt_lname']);
                                $buyeremail = validate_input($_REQUEST['txt_email']);
                                $address1 = validate_input($_REQUEST['txt_address']);
                                $address2 = validate_input($_REQUEST['txt_address2']);
                                $zipcode = validate_input($_REQUEST['txt_zip']);
                                $city = validate_input($_REQUEST['txt_city']);
                                $state = validate_input($_REQUEST['txt_state']);
                                $buyerCno = validate_input($_REQUEST['txt_buyercno']);
                                $pmethod = validate_input($_REQUEST['payment']);
                                $ziperrormsg = "Please fill in 5 digit";
                            }
                            $buyerCno = validate_input($_REQUEST['txt_buyercno']);
                            if (strlen($buyerCno) < 10) {
                                $Fname = validate_input($_REQUEST['txt_fname']);
                                $Lname = validate_input($_REQUEST['txt_lname']);
                                $buyeremail = validate_input($_REQUEST['txt_email']);
                                $address1 = validate_input($_REQUEST['txt_address']);
                                $address2 = validate_input($_REQUEST['txt_address2']);
                                $zipcode = validate_input($_REQUEST['txt_zip']);
                                $city = validate_input($_REQUEST['txt_city']);
                                $state = validate_input($_REQUEST['txt_state']);
                                $buyerCno = validate_input($_REQUEST['txt_buyercno']);
                                $pmethod = validate_input($_REQUEST['payment']);
                                $cnoerrormsg = "*Please fill in correct phone format 01123457890";
                            } else {
                                try {


                                    $Fname = validate_input($_REQUEST['txt_fname']);
                                    $Lname = validate_input($_REQUEST['txt_lname']);
                                    $buyeremail = validate_input($_REQUEST['txt_email']);
                                    $address1 = validate_input($_REQUEST['txt_address']);
                                    $address2 = validate_input($_REQUEST['txt_address2']);
                                    $zipcode = validate_input($_REQUEST['txt_zip']);
                                    $city = validate_input($_REQUEST['txt_city']);
                                    $state = validate_input($_REQUEST['txt_state']);
                                    $buyerCno = validate_input($_REQUEST['txt_buyercno']);



                                    $pmethod = validate_input($_REQUEST['payment']);
                                    $date = date('Y-m-d H:i:s');
                                    $status = "Payment comfirmed";


                                    

                                  
                                        $id = $cart['product_id'];
                                        $selectpid = "SELECT * FROM productmain2 WHERE p_id =  $id ";
                                        $resultpid = mysqli_query($conn, $selectpid);
                                        $searchpid = mysqli_fetch_all($resultpid, MYSQLI_ASSOC);
                                        foreach ($searchpid as $searchpids) :
                                            $pquantity = $searchpids['p_quantity'];

                                        endforeach;
                                        $substractitemqty = $pquantity - $cart['quantity'];
                                        $select_stmt = $db->prepare('SELECT * FROM productmain2 WHERE p_id =:id');  //sql select query
                                        $select_stmt->bindParam(':id', $id);
                                        $select_stmt->execute();


                                        $updateqty_stmt = $db->prepare('UPDATE productmain2 SET p_quantity=:cqty WHERE p_id =:id');
                                        $updateqty_stmt->bindParam(':id', $id);
                                        $updateqty_stmt->bindParam(':cqty', $substractitemqty);
                                        $updateqty_stmt->execute();

                                        $insert_stmt = $db->prepare('INSERT INTO itemhistory(order_id,product_ID,seller_email,buyer_email,itemimage,address,address2,country,state,zip,Date,Price,Product_quantity,shipping,Status,sellerCno,buyerCno,paymentmethod) VALUES(:corder_id,:cproduct_ID,:cseller_email,:cbuyer_email,:citemimage,:caddress,:caddress2,:ccountry,:cstate,:czip,:cDate,:cPrice,:cProduct_quantity,:cshipping,:cStatus,:csellerCno,:cbuyerCno,:cpaymentmethod)');
                                        $insert_stmt->bindParam(':corder_id', $oid);
                                        $insert_stmt->bindParam(':cproduct_ID', $Pid);
                                        $insert_stmt->bindParam(':cseller_email', $selleremail);
                                        $insert_stmt->bindParam(':cbuyer_email', $buyeremail);
                                        $insert_stmt->bindParam(':citemimage', $image_file1);
                                        $insert_stmt->bindParam(':caddress', $address1);
                                        $insert_stmt->bindParam(':caddress2', $address2);
                                        $insert_stmt->bindParam(':ccountry', $city);
                                        $insert_stmt->bindParam(':cstate', $state);
                                        $insert_stmt->bindParam(':czip', $zipcode);
                                        $insert_stmt->bindParam(':cDate', $date);
                                        $insert_stmt->bindParam(':cPrice', $price);
                                        $insert_stmt->bindParam(':cProduct_quantity', $qty);
                                        $insert_stmt->bindParam(':cshipping', $pshipping);
                                        $insert_stmt->bindParam(':cStatus', $status);
                                        $insert_stmt->bindParam(':csellerCno', $sellerCno);
                                        $insert_stmt->bindParam(':cbuyerCno', $buyerCno);
                                        $insert_stmt->bindParam(':cpaymentmethod', $pmethod);
                                        //bind all parameter 
                                        if ($insert_stmt->execute()) {
                                            $mail = new PHPMailer(true);
                                            $mail-> SMTPDebug =0;
                                            
                                            $mail->isSMTP();
                                            
                                            $mail->Host ='smtp.gmail.com';
                                            
                                            $mail->SMTPAuth = true;
                                            
                                            $mail->SMTPOptions =array(
                                              'ssl' => array(
                                                'verify_peer' =>false,
                                                'verify_peer_name' =>false,
                                                'allow_self_signed' => true
                                            )
                                            );
                                            
                                              $mail->Username ='startroopers321@gmail.com';
                                              $mail->Password ='StarTroopers123';
                                            
                                              $mail->SMTPSecure = "tls";
                                              $mail->Port =587;
                                            
                                              $mail->From = "startroopers321@gmail.com";
                                            
                                              $mail->addAddress("startroopers321@gmail.com", "Star Troopers");
                                              $mail->addAddress($_SESSION['user_email'], "Dark rider");
                                            
                                            
                                              $mail->isHTML(true);
                                              $mail->Subject = "Receipt of Purchase";
                                            
                                            $message ="<h1 style=text-align:center; color:black;>C.S Mini Shop</h1>" . "<p style=color:black;>Thank you for purchasing at C.S Mini shop. <br> **Please keep this message for your records.**</p>
                                            <tabel>
                                                <br>
                                                <hr>
                                                <br>
                                                <tr><td>Product Name:</td><td>".  $cart['product_name'] ."</td></tr>
                                                <tr><td>Quantity:</td><td>". $cart['quantity'] ."</td></tr>
                                                <tr><td>Shipping Method:</td><td>". $cart['shipping'] ."</td></tr>
                                                <tr><td>Total Price:</td><td>". $cart['total_price'] ."</td></tr>
                                                <br>
                                                <hr>
                                                <br>
                                                <tr><td>Seller email:</td><td>". $cart['seller_email'] ."</td></tr>
                                                <tr><td>Seller Contact:</td><td>". $cart['seller_contactNo']  ."</td></tr>
                                                <br>
                                                <hr>
                                                <br>
                                                <br>
                                                <hr>
                                                <br>
                                                <tr><td> Please do not hesitate to contact us, if there were to have problem with the purchase process. <br> Email: startroopers321@gmail.com<tr><td>
                                                
                                            </tabel>
                                            ";
                                            
                                            $mail->Body = $message;
                                            
                                            try{
                                              
                                              $mail->send();
                                              
                                            }catch(Exception $e){
                                              echo '<script> alert("Mailer Error: ") </script>' .$mail->ErrorInfo;
                                            }
                                            
                                            $updateMsg = "File Update Successfully";
                                            $sqldelete = "DELETE FROM addtocart";
                                            $delete = mysqli_query($conn, $sqldelete);
                                            echo "<meta http-equiv='refresh' content='0;Thankyou.php'>";
                                        
                                    }
                                } catch (PDOException $e) {
                                    echo $e->getMessage();
                                }
                            }
                        } else {

                            if (empty($_REQUEST['txt_fname']) || !isset($_REQUEST['txt_fname'])) {
                                $fnameerrormsg = "*Please fill in First name";
                            } else {
                                $Fname = $_REQUEST['txt_fname'];
                                $fnameerrormsg = "";
                            }
                            if (empty($_REQUEST['txt_lname']) || !isset($_REQUEST['txt_lname'])) {
                                $lnameerrormsg = "*Please fill in Last name";
                            } else {
                                $Lname = $_REQUEST['txt_lname'];
                                $lnameerrormsg = "";
                            }
                            if (empty($_REQUEST['txt_email']) || !isset($_REQUEST['txt_email'])) {
                                $emailerrormsg = "*Please fill in email";
                            } else {
                                $buyeremail = $_REQUEST['txt_email'];
                                $emailerrormsg = "";
                            }
                            if (empty($_REQUEST['txt_address']) || !isset($_REQUEST['txt_address'])) {
                                $addresserrormsg = "*Please fill in address";
                            } else {
                                $address1 = $_REQUEST['txt_address'];
                                $addresserrormsg = "";
                            }
                            if (empty($_REQUEST['txt_zip']) || !isset($_REQUEST['txt_zip'])) {
                                $ziperrormsg = "*Please fill in zip code";
                            } else {
                                $zipcode = $_REQUEST['txt_zip'];
                                $ziperrormsg = "";
                            }
                            if (empty($_REQUEST['txt_city']) || !isset($_REQUEST['txt_city'])) {
                                $cityerrormsg = "*Please fill in city";
                            } else {
                                $city = $_REQUEST['txt_city'];
                                $cityerrormsg = "";
                            }
                            if (empty($_REQUEST['txt_state']) || !isset($_REQUEST['txt_state'])) {
                                $stateerrormsg = "*Please fill in state";
                            } else {
                                $state = $_REQUEST['txt_state'];
                                $stateerrormsg = "";
                            }
                            if (empty($_REQUEST['txt_buyercno']) || !isset($_REQUEST['txt_buyercno'])) {
                                $cnoerrormsg = "*Please fill in contact number";
                            } else {
                                $buyerCno = $_REQUEST['txt_buyercno'];
                                $cnoerrormsg = "";
                            }
                        }
                    }
                }

                if (isset($_POST['creditcardcheck'])) {
                    $cartID = $cart['a_id'];
                try {
                    $id =  $cartID;
                    $select_stmt = $db->prepare('SELECT * FROM addtocart WHERE a_id =:id'); //sql select query
                    $select_stmt->bindParam(':id', $id);
                    $select_stmt->execute();
                    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
                    extract($row);
                } catch (PDOException $e) {
                    $e->getMessage();
                }
                    foreach ($carts as $cart) {
                        $pname  = $cart['product_name'];
                        $qty =  $cart['quantity'];
                        $pshipping  = $cart['shipping'];
                        $price = $cart['total_price'];
                        $selleremail = $cart['seller_email'];
                        $Pid = $cart['product_id'];
                        $sellerCno = $cart['seller_contactNo'];
                        $image_file1 = $cart['images'];


                        if (isset($_REQUEST['txt_fname'], $_REQUEST['txt_lname'], $_REQUEST['txt_email'], $_REQUEST['txt_address'], $_REQUEST['txt_zip'], $_REQUEST['txt_city'], $_REQUEST['txt_state'], $_REQUEST['txt_buyercno']) && !empty($_REQUEST['txt_fname']) && !empty($_REQUEST['txt_lname']) && !empty($_REQUEST['txt_email']) && !empty($_REQUEST['txt_address']) && !empty($_REQUEST['txt_zip']) && !empty($_REQUEST['txt_city']) && !empty($_REQUEST['txt_state']) && !empty($_REQUEST['txt_buyercno'])) {
                            $zipcode = validate_input($_REQUEST['txt_zip']);

                            if (strlen($zipcode) != 5) {

                                $Fname = validate_input($_REQUEST['txt_fname']);
                                $Lname = validate_input($_REQUEST['txt_lname']);
                                $buyeremail = validate_input($_REQUEST['txt_email']);
                                $address1 = validate_input($_REQUEST['txt_address']);
                                $address2 = validate_input($_REQUEST['txt_address2']);
                                $zipcode = validate_input($_REQUEST['txt_zip']);
                                $city = validate_input($_REQUEST['txt_city']);
                                $state = validate_input($_REQUEST['txt_state']);
                                $buyerCno = validate_input($_REQUEST['txt_buyercno']);
                                $pmethod = validate_input($_REQUEST['payment']);
                                $ziperrormsg = "Please fill in 5 digit";
                            }
                            $buyerCno = validate_input($_REQUEST['txt_buyercno']);
                            if (strlen($buyerCno) < 10) {
                                $Fname = validate_input($_REQUEST['txt_fname']);
                                $Lname = validate_input($_REQUEST['txt_lname']);
                                $buyeremail = validate_input($_REQUEST['txt_email']);
                                $address1 = validate_input($_REQUEST['txt_address']);
                                $address2 = validate_input($_REQUEST['txt_address2']);
                                $zipcode = validate_input($_REQUEST['txt_zip']);
                                $city = validate_input($_REQUEST['txt_city']);
                                $state = validate_input($_REQUEST['txt_state']);
                                $buyerCno = validate_input($_REQUEST['txt_buyercno']);
                                $pmethod = validate_input($_REQUEST['payment']);
                                $cnoerrormsg = "*Please fill in correct phone format 01123457890";
                            } else {
                                try {


                                    $Fname = validate_input($_REQUEST['txt_fname']);
                                    $Lname = validate_input($_REQUEST['txt_lname']);
                                    $buyeremail = validate_input($_REQUEST['txt_email']);
                                    $address1 = validate_input($_REQUEST['txt_address']);
                                    $address2 = validate_input($_REQUEST['txt_address2']);
                                    $zipcode = validate_input($_REQUEST['txt_zip']);
                                    $city = validate_input($_REQUEST['txt_city']);
                                    $state = validate_input($_REQUEST['txt_state']);
                                    $buyerCno = validate_input($_REQUEST['txt_buyercno']);



                                    $pmethod = validate_input($_REQUEST['payment']);
                                    $date = date('Y-m-d H:i:s');
                                    $status = "Payment comfirmed";


                                    

                                  
                                        $id = $cart['product_id'];
                                        $selectpid = "SELECT * FROM productmain2 WHERE p_id =  $id ";
                                        $resultpid = mysqli_query($conn, $selectpid);
                                        $searchpid = mysqli_fetch_all($resultpid, MYSQLI_ASSOC);
                                        foreach ($searchpid as $searchpids) :
                                            $pquantity = $searchpids['p_quantity'];

                                        endforeach;
                                        $substractitemqty = $pquantity - $cart['quantity'];
                                        $select_stmt = $db->prepare('SELECT * FROM productmain2 WHERE p_id =:id');  //sql select query
                                        $select_stmt->bindParam(':id', $id);
                                        $select_stmt->execute();


                                        $updateqty_stmt = $db->prepare('UPDATE productmain2 SET p_quantity=:cqty WHERE p_id =:id');
                                        $updateqty_stmt->bindParam(':id', $id);
                                        $updateqty_stmt->bindParam(':cqty', $substractitemqty);
                                        $updateqty_stmt->execute();

                                        $insert_stmt = $db->prepare('INSERT INTO itemhistory(order_id,product_ID,seller_email,buyer_email,itemimage,address,address2,country,state,zip,Date,Price,Product_quantity,shipping,Status,sellerCno,buyerCno,paymentmethod) VALUES(:corder_id,:cproduct_ID,:cseller_email,:cbuyer_email,:citemimage,:caddress,:caddress2,:ccountry,:cstate,:czip,:cDate,:cPrice,:cProduct_quantity,:cshipping,:cStatus,:csellerCno,:cbuyerCno,:cpaymentmethod)');
                                        $insert_stmt->bindParam(':corder_id', $oid);
                                        $insert_stmt->bindParam(':cproduct_ID', $Pid);
                                        $insert_stmt->bindParam(':cseller_email', $selleremail);
                                        $insert_stmt->bindParam(':cbuyer_email', $buyeremail);
                                        $insert_stmt->bindParam(':citemimage', $image_file1);
                                        $insert_stmt->bindParam(':caddress', $address1);
                                        $insert_stmt->bindParam(':caddress2', $address2);
                                        $insert_stmt->bindParam(':ccountry', $city);
                                        $insert_stmt->bindParam(':cstate', $state);
                                        $insert_stmt->bindParam(':czip', $zipcode);
                                        $insert_stmt->bindParam(':cDate', $date);
                                        $insert_stmt->bindParam(':cPrice', $price);
                                        $insert_stmt->bindParam(':cProduct_quantity', $qty);
                                        $insert_stmt->bindParam(':cshipping', $pshipping);
                                        $insert_stmt->bindParam(':cStatus', $status);
                                        $insert_stmt->bindParam(':csellerCno', $sellerCno);
                                        $insert_stmt->bindParam(':cbuyerCno', $buyerCno);
                                        $insert_stmt->bindParam(':cpaymentmethod', $pmethod);
                                        //bind all parameter 
                                        if ($insert_stmt->execute()) {
                                            $updateMsg = "File Update Successfully";
                                            $sqldelete = "DELETE FROM addtocart";
                                            $delete = mysqli_query($conn, $sqldelete);
                                            echo "<meta http-equiv='refresh' content='0;Thankyou.php'>";
                                        
                                    }
                                } catch (PDOException $e) {
                                    echo $e->getMessage();
                                }
                            }
                        } else {

                            if (empty($_REQUEST['txt_fname']) || !isset($_REQUEST['txt_fname'])) {
                                $fnameerrormsg = "*Please fill in First name";
                            } else {
                                $Fname = $_REQUEST['txt_fname'];
                                $fnameerrormsg = "";
                            }
                            if (empty($_REQUEST['txt_lname']) || !isset($_REQUEST['txt_lname'])) {
                                $lnameerrormsg = "*Please fill in Last name";
                            } else {
                                $Lname = $_REQUEST['txt_lname'];
                                $lnameerrormsg = "";
                            }
                            if (empty($_REQUEST['txt_email']) || !isset($_REQUEST['txt_email'])) {
                                $emailerrormsg = "*Please fill in email";
                            } else {
                                $buyeremail = $_REQUEST['txt_email'];
                                $emailerrormsg = "";
                            }
                            if (empty($_REQUEST['txt_address']) || !isset($_REQUEST['txt_address'])) {
                                $addresserrormsg = "*Please fill in address";
                            } else {
                                $address1 = $_REQUEST['txt_address'];
                                $addresserrormsg = "";
                            }
                            if (empty($_REQUEST['txt_zip']) || !isset($_REQUEST['txt_zip'])) {
                                $ziperrormsg = "*Please fill in zip code";
                            } else {
                                $zipcode = $_REQUEST['txt_zip'];
                                $ziperrormsg = "";
                            }
                            if (empty($_REQUEST['txt_city']) || !isset($_REQUEST['txt_city'])) {
                                $cityerrormsg = "*Please fill in city";
                            } else {
                                $city = $_REQUEST['txt_city'];
                                $cityerrormsg = "";
                            }
                            if (empty($_REQUEST['txt_state']) || !isset($_REQUEST['txt_state'])) {
                                $stateerrormsg = "*Please fill in state";
                            } else {
                                $state = $_REQUEST['txt_state'];
                                $stateerrormsg = "";
                            }
                            if (empty($_REQUEST['txt_buyercno']) || !isset($_REQUEST['txt_buyercno'])) {
                                $cnoerrormsg = "*Please fill in contact number";
                            } else {
                                $buyerCno = $_REQUEST['txt_buyercno'];
                                $cnoerrormsg = "";
                            }
                        }
                    }
                }
