<?php

session_start();
include_once 'Php/config.php';
include_once('server.php');

if (!isset($_SESSION['user_email'])) {
  header("Location:login.php");
}

//change database table name and column name here
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
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
  <link rel="stylesheet" type="text/css" href="Externalstylesheet/style3.css" />


  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>

  <script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
  <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
  <!-- For password eye icon -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
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

  .imgshowcase {
    width: 300px;
    height: 300px;

  }

  .imgshow {
    width: 100%;
    height: 100%;
    border-radius: 50%;
  }

  td {
    width: 60%;
  }

  h1 {
    font-family: 'Glory', sans-serif;
    color: blanchedalmond;

  }
</style>

<body>

  <body>
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
        <div class="w3-container">
          <h1>Edit Profile </h1>
          <hr style="margin: auto 15%;">
        </div>
      </center>
      <div class="w3-container">
        <center>
          <?php if (is_null($profileimg) == true || $profileimg == "") {
            $img = "blank-profile-picture-973460_640.png";
          } else {
            $img = $profileimg;
          }


          ?>
          <form action="#" method=post enctype="multipart/form-data">
            <input type="file" accept="image/gif, image/jpeg, image/png" name="image" id="file" style="display: none;" onchange="loadFile(event)" value="<?php echo $img ?>">
            <p>
            <div class="imgshowcase">
              <img src="Images/<?php echo $img ?>" class="imgshow" id="output" />
            </div>
            <br>
            <br>
            <label style="font-size: 19px;" style="cursor: pointer;" for="file">

              <i style="margin:0px;" class="fa fa-upload"></i>
              <span>
                Upload Profile Image</span></label>
        </center>

        <center>


          <table>
            <tr>
              <th>Email:</th>
              <td><input style="width:80%; border-radius: 5px; padding: 2px 5px;" type="text" name="user_email" value="<?php echo $email ?>" readonly></td>
            </tr>

            <tr>
              <th>Password:</th>
              <td><input style="width:80%; border-radius: 5px; padding: 2px 5px;" type="password" id="user_password" name="user_password" value="<?php echo $password ?>">
                <i style="color: blanchedalmond;" class="bi bi-eye-slash" id="togglePassword"></i>
              </td>
            </tr>

            <tr>
              <th>Contact No:</th>
              <td><input style="width:80%; border-radius: 5px; padding: 2px 5px;" type="text" name="user_contact" id="user_contact" value="<?php echo $contact_no; ?>"></td>
            </tr>
          </table>

          <br>

          <button style="font-size: 20px;" class="btn btn-dark" type="submit" name="update" onclick="return confirm('Are you sure you want to update your profile information?')">update</button>

          </form>
        </center>
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
</script>
<script>
  const togglePassword = document.querySelector('#togglePassword');
  const password = document.querySelector('#user_password');

  togglePassword.addEventListener('click', function(e) {
    // toggle the type attribute
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    // toggle the eye / eye slash icon
    this.classList.toggle('bi-eye');
  });

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
setInputFilter(document.getElementById('user_contact'), function(value){
   
   return /^-?\d*$/.test(value);
  }

);

</script>