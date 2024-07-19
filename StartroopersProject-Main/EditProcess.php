<?php

session_start();
  // if user didnt login, bring them to login page
if (!isset($_SESSION['user_email'])) {
  header("Location:login.php");
}
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
?>
<?php

require_once "Php/connection.php";
//Update the item
if (isset($_REQUEST['update_id'])) {
  try {
    $id = $_REQUEST['update_id'];
    $select_stmt = $db->prepare('SELECT * FROM productmain2 WHERE p_id =:id');
    $select_stmt->bindParam(':id', $id);
    $select_stmt->execute();
    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
    extract($row);
  } catch (PDOException $e) {
    $e->getMessage();
  }
}

if (isset($_REQUEST['btn_update'])) {
  if (isset($_REQUEST['pname'], $_REQUEST['pemail'], $_REQUEST['TelNo'], $_REQUEST['description'], $_POST['price'], $_REQUEST['quantity']) && !empty($_REQUEST['pname']) && !empty($_REQUEST['pemail']) && !empty($_REQUEST['TelNo']) && !empty($_REQUEST['description']) && !empty($_REQUEST['price']) && !empty($_REQUEST['quantity'])) {

//Fliter email
    if (filter_var($_POST['pemail'], FILTER_VALIDATE_EMAIL) == false) {
      $p_email = $_REQUEST['pemail'];
      $TelNo = $_REQUEST['TelNo'];
      $des = $_REQUEST['description'];
      $quantity = floatval($_REQUEST['quantity']);
      $pname = $_REQUEST['pname'];
      $pcondition = $_REQUEST['p_condition'];
      $price = floatval($_REQUEST['price']);
      $pshipping = $_REQUEST['shipping'];
      $pcategory = $_REQUEST['category'];
      $fliteremailerro = 'Please enter valid email address';
    } else {

      try {
        $p_email = $_REQUEST['pemail'];
        $TelNo = $_REQUEST['TelNo'];
        $des = $_REQUEST['description'];
        $quantity = floatval($_REQUEST['quantity']);
        $pname = $_REQUEST['pname'];
        $pcondition = $_REQUEST['p_condition'];
        $price = floatval($_REQUEST['price']);
        $pshipping = $_REQUEST['shipping'];
        $pcategory = $_REQUEST['category'];
        $pstatus = "pstatus";

        $image_file  = $_FILES["txt_file"]["name"];
        $type    = $_FILES["txt_file"]["type"];
        $size    = $_FILES["txt_file"]["size"];
        $temp    = $_FILES["txt_file"]["tmp_name"];

        $image_file0  = $_FILES["image"]["name"];
        $type0    = $_FILES["image"]["type"];
        $size0    = $_FILES["image"]["size"];
        $temp0    = $_FILES["image"]["tmp_name"];

        $image_file1 = $_FILES["image1"]["name"];
        $type1    = $_FILES["image1"]["type"];
        $size1    = $_FILES["image1"]["size"];
        $temp1    = $_FILES["image1"]["tmp_name"];

        $image_file2  = $_FILES["image2"]["name"];
        $type2    = $_FILES["image2"]["type"];
        $size2    = $_FILES["image2"]["size"];
        $temp2    = $_FILES["image2"]["tmp_name"];




        if ($image_file) {
          if ($type == "image/jpg" || $type == 'image/jpeg' || $type == 'image/png' || $type == 'image/gif') //check file extension
          {

            if ($size < 5000000) //check file size 5MB
            {
              //move upload file temperory directory to your Images folder	
              move_uploaded_file($temp, "Images/" . $image_file);
            } else {
              $errorMsg = "Your File To large Please Upload 5MB Size"; //error message file size not large than 5MB
            }
          } else {
            $errorMsg = "Upload JPG, JPEG, PNG & GIF File Formate.....CHECK FILE EXTENSION"; //error message file extension
          }
        } else {
          //if you not select new image than previous image same it is it.
          $image_file = $row['p_image'];
        }


        if ($image_file0) {
          if ($type0 == "image/jpg" || $type0 == 'image/jpeg' || $type0 == 'image/png' || $type0 == 'image/gif') //check file extension
          {

            if ($size0 < 5000000) //check file size 5MB
            {
              //move upload file temperory directory to your Images folder	
              move_uploaded_file($temp0, "Images/" . $image_file0);
            } else {
              $errorMsg = "Your File To large Please Upload 5MB Size"; //error message file size not large than 5MB
            }
          } else {
            $errorMsg = "Upload JPG, JPEG, PNG & GIF File Formate.....CHECK FILE EXTENSION"; //error message file extension
          }
        } else {
          //if you not select new image than previous image same it is it.
          $image_file0 = $row['image2'];
        }


        if ($image_file1) {
          if ($type1 == "image/jpg" || $type1 == 'image/jpeg' || $type1 == 'image/png' || $type1 == 'image/gif') //check file extension
          {

            if ($size1 < 5000000) //check file size 5MB
            {
              //move upload file temperory directory to your Images folder	
              move_uploaded_file($temp1, "Images/" . $image_file1);
            } else {
              $errorMsg = "Your File To large Please Upload 5MB Size"; //error message file size not large than 5MB
            }
          } else {
            $errorMsg = "Upload JPG, JPEG, PNG & GIF File Formate.....CHECK FILE EXTENSION"; //error message file extension
          }
        } else {
          //if you not select new image than previous image same it is it.
          $image_file1 = $row['image3'];
        }

        if ($image_file2) {
          if ($type2 == "image/jpg" || $type2 == 'image/jpeg' || $type2 == 'image/png' || $type2 == 'image/gif') //check file extension
          {

            if ($size2 < 5000000) //check file size 5MB
            {
              //move upload file temperory directory to your Images folder	
              move_uploaded_file($temp2, "Images/" . $image_file2);
            } else {
              $errorMsg = "Your File To large Please Upload 5MB Size"; //error message file size not large than 5MB
            }
          } else {
            $errorMsg = "Upload JPG, JPEG, PNG & GIF File Formate.....CHECK FILE EXTENSION"; //error message file extension
          }
        } else {
          //if you not select new image than previous image same it is it.
          $image_file2 = $row['image4'];
        }

        if (!isset($errorMsg)) {
          $update_stmt = $db->prepare('UPDATE productmain2 SET user_email =:p_email,
           user_phone =:p_phone,
           p_des =:p_description,
           p_quantity =:quantity,
           p_name=:name_p,
           p_condition=:condition,
           p_price=:p_price,
           p_shipping=:shipping,
           p_category=:category,
           p_image=:images,
           image2=:images0,
           image3=:images1,
           image4=:images2 
           WHERE p_id =:id');
          $update_stmt->bindParam(':p_email', $p_email);
          $update_stmt->bindParam(':p_phone', $TelNo);
          $update_stmt->bindParam(':p_description', $des);
          $update_stmt->bindParam(':quantity', $quantity);
          $update_stmt->bindParam(':name_p', $pname);
          $update_stmt->bindParam(':condition', $pcondition);
          $update_stmt->bindParam(':p_price', $price);
          $update_stmt->bindParam(':shipping', $pshipping);
          $update_stmt->bindParam(':category', $pcategory);
          $update_stmt->bindParam(':images', $image_file);
          $update_stmt->bindParam(':images0', $image_file0);
          $update_stmt->bindParam(':images1', $image_file1);
          $update_stmt->bindParam(':images2', $image_file2);
          //bind all parameter
          $update_stmt->bindParam(':id', $id);

          if ($update_stmt->execute()) {
            $updateMsg = "File Update Successfully.......";
            header("refresh:0;EditItemPage.php");  //file update success message
            //refresh 3 second and redirect to index.php page
          }
        }
      } catch (PDOException $e) {
        echo $e->getMessage();
      }
    }
  } else {

    if (empty($_REQUEST['pname']) || !isset($_REQUEST['pname'])) {
      $nameerrormsg = "*Please fill in item name";
    } else {
      $pname = $_REQUEST['pname'];
      $nameerrormsg = "";
    }

    if (empty($_REQUEST['pemail']) || !isset($_REQUEST['pemail']) && filter_var($_REQUEST['pemail'], FILTER_VALIDATE_EMAIL) == false) {
      $emailerrormsg = "*Please fill in email/fill a valid email";
    } else {
      $p_email = $_REQUEST['pemail'];
      $emailerrormsg = "";
    }
    if (empty($_REQUEST['TelNo']) || !isset($_REQUEST['TelNo'])) {
      $contacterrormsg = "*Please fill in contact number";
    } else {
      $TelNo = $_REQUEST['TelNo'];
      $contacterrormsg = "";
    }
    if (empty($_REQUEST['description']) || !isset($_REQUEST['description'])) {
      $deserrormsg = "*Please fill in description";
    } else {
      $des = $_REQUEST['description'];
      $deserrormsg = "";
    }
    if (empty($_REQUEST['price']) || !isset($_REQUEST['price'])) {
      $priceerrormsg = "*Please fill in price";
    } else {
      $price = floatval($_REQUEST['price']);
      $priceerrormsg = "";
    }
    if (empty($_PO_REQUESTST['quantity']) || !isset($_REQUEST['quantity'])) {
      $qtyerrormsg = "*Please fill in quantity";
    } else {
      $quantity = floatval($_REQUEST['quantity']);
      $qtyerrormsg = "";
    }
  }
}

?>
<?php
include_once "Php/config.php";
$sql3 = "SELECT * FROM category";
$result3 = mysqli_query($conn, $sql3);
$categories = mysqli_fetch_all($result3, MYSQLI_ASSOC);


$shipsql = "SELECT * FROM shipping";
$sresult = mysqli_query($conn, $shipsql);
$s_shipping = mysqli_fetch_all($sresult, MYSQLI_ASSOC);
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
</div>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CS.Mini Shop</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
  <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
  <link rel="stylesheet" type="text/css" href="Externalstylesheet/style3.css" />
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

  *,
  *:before,
  *:after {
    box-sizing: border-box;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
  }
  .app-form-group input,.app-form-group select,.app-form-group textarea{
    font-size: 18px;
  }
  .imgshowcase {

    box-shadow: 0px 0px 10px black;
    height: 130px;

  }

  .imgshow {
    width: 100%;
    height: 100%;
  }

  optgroup {
    color: black;
  }

  svg {
    margin-top: -10px;
    margin-left: 10px;

  }

  label {
    color: blanchedalmond;

  }

  .fa {
    margin: 0px;
  }
</style>



<?php
include "Php/header.php";
?>
<?php
include "Php/sidebar.php"
?>
<div class="w3">
  <button id="openNav" class="w3-button w3-black w3-xlarge" style="border-radius: 50px; margin: 5px 5px;" onclick="w3_open()">&#9776;</button>
</div>
<div id="main">
  <center>


  </center>

  <div class="background">
    <div class="container">
      <div class="screen">
        <div class="screen-header">
          <div class="screen-header-left">
            <div class="screen-header-button close"></div>
            <div class="screen-header-button maximize"></div>
            <div class="screen-header-button minimize"></div>
          </div>
          <div class="screen-header-right">
            <div class="screen-header-ellipsis"></div>
            <div class="screen-header-ellipsis"></div>
            <div class="screen-header-ellipsis"></div>
          </div>
        </div>

        <div class="screen-body">
          <div class="screen-body-item left">
            <div class="app-title">
              <span style="font-size: 30px;">Edit Item<svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                  <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                </svg></span>
            </div>
            <form method="POST" enctype="multipart/form-data">
              <div class="screen-body-item">
                <div class="app-form">
                  <div class="app-form-group">
                    <input class="app-form-control" placeholder="Item Name" type="text" name="pname" id="pname" value="<?php echo (isset($pname) && !empty($pname)) ? $pname : $p_name ?>">
                    <div class="errormsg">
                       <!-- display error message -->
                      <i><?php echo $nameerrormsg  ?></i>
                    </div>
                   
                  </div>
                  <div style="display: none;">
                    <div class="app-form-group">
                      <input class="app-form-control" placeholder="Your email" type="text" name="pemail" id="pemail" value="<?php echo $_SESSION['user_email'] ?>">
                      <input class="app-form-control" placeholder="Your email" type="text" name="pstatus" id="pstatus" value="<?php echo $p_status ?>">
                      <div class="errormsg">
                        <!-- display error message -->
                        <i><?php echo $emailerrormsg ?>
                          <?php echo $fliteremailerro ?>
                        </i>
                      </div>
                    </div>
                  </div>
                  <div class="app-form-group">
                    <input class="app-form-control" placeholder="CONTACT NO" type="tel" name="TelNo" id="TelNo" value="<?php echo (isset($TelNo) && !empty($TelNo)) ? $TelNo : $user_phone ?>">
                    <div class="errormsg">
                      <!-- display error message -->
                      <i><?php echo  $contacterrormsg ?></i>
                    </div>
                  </div>
                  <div class="app-form-group message">
                    <textarea class="app-form-control" placeholder="DESCRIPTIONS" name="description" id="description" cols="20" rows="2"><?php echo (isset($des) && !empty($des)) ? $des : $p_des ?></textarea>
                    <div class="errormsg">
                      <!-- display error message -->
                      <i><?php echo $deserrormsg ?></i>
                    </div>
                  </div>
                  <div class="app-form-group">
                    <select name="p_condition" required class="app-form-control">
                      <optgroup label="Current Condition">
                        <option value="<?php echo $p_condition;  ?>"><?php echo $p_condition;  ?></option>

                      </optgroup>
                      <optgroup label="Select NEw Condition">

                        <option value="New">New</option>
                        <option value="Used">Used</option>
                      </optgroup>
                    </select>
                  </div>
                  <div class="app-form-group">
                    <input class="app-form-control" placeholder="PRICE" type="text" name="price" id="price" value="<?php echo (isset($price) && !empty($price)) ? $price : number_format($p_price, 2) ?>">
                    <div class="errormsg">
                      <!-- display error message -->
                      <i><?php echo  $priceerrormsg ?></i>
                    </div>
                  </div>
                  <div class="app-form-group">
                    <input class="app-form-control" placeholder="QUANTITY" type="number" name="quantity" id="quantity" min="0" value="<?php echo (isset($quantity) && !empty($quantity)) ? $quantity : $p_quantity ?>">
                    <div class="errormsg">
                      <!-- display error message -->
                      <i><?php echo $qtyerrormsg ?></i>
                    </div>
                  </div>
                  <div class="app-form-group">
                    <select name="category" required class="app-form-control">
                      <optgroup label="Current Item Category">
                        <option value="<?php echo $p_category;  ?>"><?php echo $p_category;  ?></option>

                      </optgroup>
                      <optgroup label="Select New Item Category">

                        <?php foreach ($categories as $category) : ?>
                          <option value="<?php echo $category['CategoryTitle']; ?>"><?php echo $category['CategoryTitle']; ?></option>
                        <?php endforeach; ?>
                      </optgroup>


                    </select>
                  </div>
                  <div class="app-form-group">
                    <select name="shipping" required class="app-form-control">
                      <optgroup label="Current Shipping Method">
                        <option value="<?php echo $p_shipping;  ?>"><?php echo $p_shipping;  ?></option>

                      </optgroup>
                      <optgroup label="Select New Shipping Method">

                        <?php foreach ($s_shipping as $ship) : ?>
                          <option value="<?php echo $ship['s_method']; ?>"><?php echo $ship['s_method']; ?></option>
                        <?php endforeach; ?>
                      </optgroup>

                    </select>
                  </div>
                  <br>
                  <div class="container">
                    <div id="images"> <img src="Images/<?php echo $p_image; ?>" alt=""> </div>
                    <br>
                    <input value="<?php echo $p_image; ?>" name="txt_file" type="file" id="file-input" accept="images/png, images/jpeg" onchange="preview()">
                    <label class="piclabel" id="button" for="file-input">
                      <i style="margin: 0px;" class="fa fa-upload"></i> Upload Images
                    </label>
                    <div style="display: none;">
                      <p id="number-of-img">No product selected yet!</p>
                    </div>
                  </div>
                  <div>
                    <div class="row">
                      <div class="col-4">
                        <input type="file" accept="image/gif, image/jpeg, image/png" name="image" id="file" style="display: none;" onchange="loadFile(event)" value=" <?php echo $image2; ?>">
                        <p>
                        <div class="imgshowcase">
                          <img src="Images/<?php echo $image2 ?>" class="imgshow" id="output" />
                        </div>
                        <br>
                        <label style="cursor: pointer;" for="file">
                          <i style="margin: 0px;" class="fa fa-upload"></i> Upload Image</label> </p>
                      </div>
                      <div class="col-4">
                        <input type="file" accept="image/gif, image/jpeg, image/png" name="image1" id="image1" style="display: none;" onchange="loadFile1(event)" value="<?php echo $image3; ?>">
                        <p>
                        <div class="imgshowcase">
                          <img src="Images/<?php echo $image3 ?>" class="imgshow" id="output1" />
                        </div>
                        <br>
                        <label style="cursor: pointer;" for="image1">
                          <i style="margin: 0px;" class="fa fa-upload"></i> Upload Image</label> </p>
                      </div>
                      <div class="col-4">
                        <input type="file" accept="image/gif, image/jpeg, image/png" name="image2" id="file2" style="display: none;" onchange="loadFile2(event)" value=" <?php echo $image4; ?>">
                        <p>
                        <div class="imgshowcase">
                          <img src="Images/<?php echo $image4 ?>" class="imgshow" id="output2" />
                        </div>
                        <br>
                        <label style="cursor: pointer;" for="file2">
                          <i style="margin: 0px;" class="fa fa-upload"></i><span>Upload Image</span> </label> </p>
                      </div>

                    </div>





                  </div>
                  <script src="JS/UploadPicture.js"></script>
                  <br>
                  <div class="app-form-group buttons">
                   
                    <button style="font-size: 18px;" type="submit" name="btn_update" class="app-form-button">SAVE</button>



                  </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

</div>
</body>
<script src="JS/sidebarbutton.js"></script>

</html>
<script>
  var loadFile = function(event) {
    var image = document.getElementById('output');
    image.src = URL.createObjectURL(event.target.files[0]);
  }
  var loadFile1 = function(event) {
    var image = document.getElementById('output1');
    image.src = URL.createObjectURL(event.target.files[0]);
  }
  var loadFile2 = function(event) {
    var image = document.getElementById('output2');
    image.src = URL.createObjectURL(event.target.files[0]);
  }
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
            
     

            setInputFilter(document.getElementById('price'), function(value) {

return /^-?\d*[.]?\d{0,2}$/.test(value);
});
</script>