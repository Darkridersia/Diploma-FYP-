<?php
    include 'config.php';
  
    $customer_id = $_POST["product_id"];
    $customer_name = $_POST["product_name"];
   
    $profileImageName = time(). '_' . $_FILES['profileImage']['name'];
    $target = 'Images/' . $profileImageName;


    $sql = "UPDATE productmain SET product_id = '".$customer_id."', product_name = '". $customer_name."', images = '" .$profileImageName."' WHERE product_id = '" .$customer_id ."';";
    
    if($conn -> query($sql) === TRUE){
        echo "Customer Record Updated successfully.";
    }else{
        echo "Error: " .$sql . "<br>" . $conn -> error;
    }



?>