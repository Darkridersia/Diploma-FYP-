   <?php

session_start();
    if(isset($_POST['adminid'])){
        $accid = $_POST["adminid"];
        $password = $_POST["password"];
        $error = "unsername/password is incorrect";
        
      //check if the password 
       if($accid == "admin01" && $password=="admin01"){

         $_SESSION["adminid"] = $accid;
         header("location:../index.html");
     //if correct, go to the next page
          
       }else {
    //incorrect, stay on login page
           $_SESSION["error"] = $error;
           header("location:../Admin.php");
       }
    
    }
    ?>








     