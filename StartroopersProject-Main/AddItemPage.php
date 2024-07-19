<?php
session_start();
// if user didnt login, bring them to login page
if (!isset($_SESSION['user_email'])) {
  header("Location:login.php");
}
$_SESSION['user_email'];
$_SESSION['user_contact'];
include "Php/processUploadFile2.php";

$sql = "SELECT * FROM category";
$result = mysqli_query($conn, $sql);
$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);


$shipsql = "SELECT * FROM shipping";
$sresult = mysqli_query($conn, $shipsql);
$s_shipping = mysqli_fetch_all($sresult, MYSQLI_ASSOC);

?>
<?php
// search keyword coding part
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
<?php echo $fileerrormsg ?>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="Externalstylesheet/style3.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
<script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

   <!-- google font-->
   <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Glory:wght@500&display=swap" rel="stylesheet">
  <!-- font-family: 'Glory', sans-serif;   -->
  <!-- google font-->
</head>
<style>
  *{
    font-family: 'Glory', sans-serif;
 
  }
  i{
    font-family: 'Glory', sans-serif;
  }
  *,
  *:before,
  *:after {
    box-sizing: border-box;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
  }

  .container {
    flex: 0 1 700px;
    margin: auto;
    padding: 10px;
    font-size: 20px;
  }

  .imgshowcase {

    box-shadow: 0px 0px 10px black;
    height: 130px;

  }

  .container {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    text-align: center;
    width: 40%;
    min-width: 500px;
    position: relative;
    padding: 60px 30px;
    border-radius: 7px;
    box-shadow: 0 9px 20px rgba(2, 2, 2, 0.116);
    user-select: none;
 
  }
  .app-form-group input,.app-form-group select,.app-form-group textarea{
    font-size: 18px;
  }

  .errormsg {
    color: red;
    float: left;
    margin-left: 30px;
  }

  label {
    color: blanchedalmond;
  }

  .app-title svg {
    margin: 0px 0px 10px 10px;
    padding: 1px;



  }

  .imgshow {
    width: 100%;
    height: 100%;
  }
 
.piclabel .tooltipcontent{

  visibility: hidden;
  width: 120px;
  margin-top: 50px;
 font-size: 15px;

  background-color: black;
  color: #fff;
  text-align: center;
  padding: 5px;
  border-radius: 6px;
 margin-left: -125px;
  position: absolute;
  z-index: 1;
}
.piclabel:hover .tooltipcontent {
  visibility: visible;
}
</style>


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
              <span>Add an Item<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-basket" viewBox="0 0 16 16">
                  <path d="M5.757 1.071a.5.5 0 0 1 .172.686L3.383 6h9.234L10.07 1.757a.5.5 0 1 1 .858-.514L13.783 6H15a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1v4.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 13.5V9a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h1.217L5.07 1.243a.5.5 0 0 1 .686-.172zM2 9v4.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V9H2zM1 7v1h14V7H1zm3 3a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 4 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 6 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 8 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 1 .5-.5zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 1 .5-.5z" />
                </svg></span>
                <!-- fill in item details at here -->
            </div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
              <div class="screen-body-item">
                <div class="app-form">
                  <div class="app-form-group">
                    <input required class="app-form-control" placeholder="Item Name" type="text" name="pname" id="pname" value="<?php echo (isset($pname) && !empty($pname)) ? $pname : '' ?>">
                    <div class="errormsg">
                      <i><?php echo $nameerrormsg  ?></i>
                    </div>
                  </div>
                  <div style="display: none;">
                    <div class="app-form-group">
                      <input required class="app-form-control" placeholder="Your email" type="text" name="pemail" id="pemail" value="<?php echo $_SESSION['user_email'] ?>">
                      <div class="errormsg">
                        <i><?php echo $emailerrormsg ?>
                          <?php echo $fliteremailerro ?>
                        </i>
                      </div>
                    </div>
                  </div>
                  <div class="app-form-group">
                    <input required class="app-form-control" placeholder="CONTACT NO" type="tel" name="TelNo" id="TelNo" value="<?php echo (isset($TelNo) && !empty($TelNo)) ? $TelNo : $_SESSION['user_contact']; ?>">
                    <div class="errormsg">
                      <i><?php echo  $contacterrormsg ?></i>
                    </div>
                  </div>
                  <div class="app-form-group message">
                    <textarea class="app-form-control" placeholder="DESCRIPTIONS" name="description" id="description" cols="20" rows="2"><?php echo (isset($des) && !empty($des)) ? $des : '' ?></textarea>
                    <div class="errormsg">
                      <i><?php echo $deserrormsg ?></i>
                    </div>
                  </div>
                  <div class="app-form-group">
                    <select name="p_condition" required class="app-form-control">
                      <option value="" disabled selected>PLEASE SELECT COndition</option>

                      <option value="New">New</option>
                      <option value="Used">Used</option>
                    </select>
                  </div>
                  <div class="app-form-group">
                    <input required class="app-form-control" placeholder="PRICE" type="text" name="price" id="price" value="<?php echo (isset($price) && !empty($price)) ? $price : '' ?>">
                    <div class="errormsg">
                      <i><?php echo  $priceerrormsg ?></i>
                    </div>
                  </div>
                  <div class="app-form-group">
                    <input class="app-form-control" placeholder="QUANTITY" type="number" name="quantity" id="quantity" min="1" value="<?php echo (isset($quantity) && !empty($quantity)) ? $quantity : '' ?>">
                    <div class="errormsg">
                      <i><?php echo $qtyerrormsg ?></i>
                    </div>
                  </div>
                  <div class="app-form-group">
                    <select name="category" required class="app-form-control">
                      <option value="" disabled selected>Please select item category</option>
                      <?php foreach ($categories as $category) : ?>
                        <option value="<?php echo $category['CategoryTitle']; ?>"><?php echo $category['CategoryTitle']; ?></option>
                      <?php endforeach; ?>

                    </select>
                  </div>
                  <div class="app-form-group">
                    <select name="shipping" required class="app-form-control">
                      <option value="" disabled selected>PLEASE SELECT SHIPPING METHOD</option>
                      <?php foreach ($s_shipping as $ship) : ?>
                        <option value="<?php echo $ship['s_method']; ?>"><?php echo $ship['s_method']; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <br>
                  <div class="container">
                    <br>

                    <br>
                    <!-- insert image at here -->
                    <div id="images"></div>
                    <input name="profileImage" type="file" id="file-input" accept="images/png, images/jpeg" onchange="preview()">

                    <label class="piclabel" id="button" for="file-input">

                      <i style="margin: 0px;" class="fa fa-upload"></i>Upload Images
                        <span class="tooltipcontent">
                          Put your first image at here!
                        </span>

                    </label>
                    <div style="display: none;">
                      <p id="number-of-img">No product selected yet!</p>
                    </div>
                  </div>

                  <div>
                    <? echo $imageserror ?>
                  </div>


                  <div>
                    <div  class="row">



                      <div class="col-4">
                        <input type="file" accept="image/gif, image/jpeg, image/png" name="image" id="file" style="display: none;" onchange="loadFile(event)" value="No_Image_Available.jpg">
                        <p>
                        <div class="imgshowcase">
                          <img src="Images/No_Image_Available.jpg" class="imgshow" id="output" />
                        </div>
                        <br>
                        <label style="cursor: pointer;" for="file">
                          <i style="margin: 0px;" class="fa fa-upload"></i> Upload Image</label> </p>

                      </div>



                      <div class="col-4">
                        <input type="file" accept="image/gif, image/jpeg, image/png" name="image1" id="image1" style="display: none;" onchange="loadFile1(event)">
                        <p>
                        <div class="imgshowcase">
                          <img src="Images/No_Image_Available.jpg" class="imgshow" id="output1" />
                        </div>
                        <br>
                        <label style="cursor: pointer;" for="image1">
                          <i style="margin: 0px;" class="fa fa-upload"></i> Upload Image</label> </p>
                      </div>




                      <div class="col-4">
                        <input type="file" accept="image/gif, image/jpeg, image/png" name="image2" id="file2" style="display: none;" onchange="loadFile2(event)">
                        <p>
                        <div class="imgshowcase">
                          <img src="Images/No_Image_Available.jpg" class="imgshow" id="output2" src="" />
                        </div>
                        <br>
                        <label style="cursor: pointer;" for="file2">
                          <i style="margin: 0px;" class="fa fa-upload"></i> <span>Upload Image</span> </label> </p>
                      </div>

                    </div>




                        <!-- submit item details -->
                  </div>
                  <script src="JS/UploadPicture.js"></script>
                  <br>
                  <div class="app-form-group buttons">
                    
                    <button style="font-size: 20px;" type="submit" name="send" class="app-form-button">SEND</button>
                    <?php if (!empty($msg)) : ?>
                      <div class="alert <?php echo $css_class; ?>">
                        <?php echo $msg; ?>

                      </div>

                    <?php endif; ?>

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
}

);
</script>