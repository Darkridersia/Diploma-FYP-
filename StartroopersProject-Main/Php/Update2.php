<?php
    include 'config.php';

    $product_id = $_POST['product_id'];
    $p_name = $_POST['product_name'];
    $stuId = $_POST['student_id'];
    $TelNo = $_POST['contact_no'];
    $des = $_POST['p_description'];
    $price = floatval($_POST['price']);
    $quantity = floatval($_POST['stock']);
    $shipping = $_POST['received_method'];
    
   

    $sql = "UPDATE productmain SET product_name = '". $p_name."', student_id = '" .$stuId."', contact_no = '" .$TelNo."', p_description = '" .$des."', price = '" .$price."', quantity = '" .$quantity."',received_method  = '" .$shipping."' WHERE product_id = '" .$product_id ."';";
    
    if($conn -> query($sql) === TRUE){
        echo "Customer Record Updated successfully.";
    }else{
        echo "Error: " .$sql . "<br>" . $conn -> error;
    }

 


?>
