<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "startroopersproject";

   //do the connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    

   //check whether if it is connected
    if($conn -> connect_error){
        die("Connection Faied" .$conn -> connect_error);
    }

?>