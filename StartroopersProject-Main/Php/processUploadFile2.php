<?php
include "config.php";
include_once "connection.php";
$msg = "";
$emailerrormsg = "";
$css_class = "";
$nameerrormsg = "";
$contacterrormsg = "";
$deserrormsg = "";
$priceerrormsg = "";
$qtyerrormsg = "";
$fliteremailerro = "";
$fileerrormsg = "";

if (isset($_POST['send'])) {
    if (isset($_POST['pname'], $_POST['pemail'], $_POST['TelNo'], $_POST['description'], $_POST['price'], $_POST['quantity']) && !empty($_POST['pname']) && !empty($_POST['pemail']) && !empty($_POST['TelNo']) && !empty($_POST['description']) && !empty($_POST['price']) && !empty($_POST['quantity'])) {


        if (filter_var($_POST['pemail'], FILTER_VALIDATE_EMAIL) == false) {
            $p_email = $_POST['pemail'];
            $TelNo = $_POST['TelNo'];
            $des = $_POST['description'];
            $quantity = floatval($_POST['quantity']);
            $pname = $_POST['pname'];
            $pcondition = $_POST['p_condition'];
            $price = floatval($_POST['price']);
            $pshipping = $_POST['shipping'];
            $pcategory = $_POST['category'];
            $fliteremailerro = 'Please enter valid email address';
        } 
        $TelNo = $_POST['TelNo'];
        if(strlen($TelNo) < 10 ){
            $p_email = $_POST['pemail'];
            $TelNo = $_POST['TelNo'];
            $des = $_POST['description'];
            $quantity = floatval($_POST['quantity']);
            $pname = $_POST['pname'];
            $pcondition = $_POST['p_condition'];
            $price = floatval($_POST['price']);
            $pshipping = $_POST['shipping'];
            $pcategory = $_POST['category'];
            $contacterrormsg = '*Please fill in correct format phone number. Exmple: 011-12345678';
 


        }
        
        
        
        
        else {
            $p_email = $_POST['pemail'];
            $TelNo = $_POST['TelNo'];
            $des = $_POST['description'];
            $quantity = floatval($_POST['quantity']);
            $pname = $_POST['pname'];
            $pcondition = $_POST['p_condition'];
            $price = floatval($_POST['price']);
            $pshipping = $_POST['shipping'];
            $pcategory = $_POST['category'];
            $pstatus = "active";

           

            if (!is_uploaded_file( $_FILES['image']['tmp_name'])) {
                $profileImageName0 =  "No_Image_Available.jpg";
            } else {
                $profileImageName0 = time() . '_' . $_FILES['image']['name'];
                $target0 = 'Images/' . $profileImageName0;
                move_uploaded_file($_FILES['image']['tmp_name'], $target0);
            }







            if (!is_uploaded_file($_FILES['image1']['tmp_name'])) {
                $profileImageName1 =  "No_Image_Available.jpg";
            } else {
                $profileImageName1 = time() . '_' . $_FILES['image1']['name'];
                $target1 = 'Images/' . $profileImageName1;
                move_uploaded_file($_FILES['image1']['tmp_name'], $target1);
            }





            if (!is_uploaded_file( $_FILES['image2']['tmp_name'])) {
                $profileImageName2 =  "No_Image_Available.jpg";
            } else {
                $profileImageName2 = time() . '_' . $_FILES['image2']['name'];
                $target2 = 'Images/' . $profileImageName2;
                move_uploaded_file($_FILES['image2']['tmp_name'], $target2);
            }






            $profileImageName = time() . '_' . $_FILES['profileImage']['name'];
            $target = 'Images/' . $profileImageName;




            if (move_uploaded_file($_FILES['profileImage']['tmp_name'], $target)) {
                $sql = "INSERT INTO productmain2(user_email,
    user_phone,
    p_des,
    p_quantity,
    p_name,
    p_condition,
    p_price,
    p_shipping,
    p_category,
    p_image,
    image2,
    image3,
    image4,
    p_status) 
    VALUES 
    ('$p_email',
    '$TelNo',
    '$des',
    '$quantity',
    '$pname',
    '$pcondition',
    '$price',
    '$pshipping',
    '$pcategory',
    '$profileImageName'
    ,'$profileImageName0'
    ,'$profileImageName1'
    ,'$profileImageName2'
    ,'$pstatus'
    )";
                if (mysqli_query($conn, $sql)) {
                    $msg = "Image uploaded and saved to database";
                    $css_class = "alert-success";
                    echo "<meta http-equiv='refresh' content='2;AddItemPage.php'>";
                } else {
                    $msg = "upload failed, database error";
                    $css_class = "alert-danger";
                }
            } else {
                $msg = "Please insert atleast one images";
                $css_class = "alert-danger";
            }
        }
    } else {

        if (empty($_POST['pname']) || !isset($_POST['pname'])) {
            $nameerrormsg = "*Please fill in item name";
        } else {
            $pname = $_POST['pname'];
            $nameerrormsg = "";
        }

        if (empty($_POST['pemail']) || !isset($_POST['pemail']) && filter_var($_POST['pemail'], FILTER_VALIDATE_EMAIL) == false) {
            $emailerrormsg = "*Please fill in email/fill a valid email";
        } else {
            $p_email = $_POST['pemail'];
            $emailerrormsg = "";
        }
        if (empty($_POST['TelNo']) || !isset($_POST['TelNo'])) {
            $contacterrormsg = "*Please fill in contact number";
        } else {
            $TelNo = $_POST['TelNo'];
            $contacterrormsg = "";
        }
        if (empty($_POST['description']) || !isset($_POST['description'])) {
            $deserrormsg = "*Please fill in description";
        } else {
            $des = $_POST['description'];
            $deserrormsg = "";
        }
        if (empty($_POST['price']) || !isset($_POST['price'])) {
            $priceerrormsg = "*Please fill in price";
        } else {
            $price = floatval($_POST['price']);
            $priceerrormsg = "";
        }
        if (empty($_POST['quantity']) || !isset($_POST['quantity'])) {
            $qtyerrormsg = "*Please fill in quantity";
        } else {
            $quantity = floatval($_POST['quantity']);
            $qtyerrormsg = "";
        }
    }
}
