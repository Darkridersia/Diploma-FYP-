
<?php

include_once "config.php";
$sql3 = "SELECT * FROM category";
$result3 = mysqli_query($conn, $sql3);
$categories = mysqli_fetch_all($result3, MYSQLI_ASSOC);
?>
<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
<style>
  .container-fluid a{
    font-size: 20px;
  }
  .admin{
    display: block;

  }
  .user{
    display: none;
  }
  .containitem {
      margin: 0px 25%;

    }

@media screen and (max-width:1300px){
  .containitem {
      margin: 0px 15%;

    }

}
.logoutbtn{
    margin: auto 0px auto 10px;
   
  
  
  }
  .logoutbtn svg{
    border-radius:20px;
    background-color: rgb(90, 88, 88);
    color: black;
width: 50px;
height: 50px;
padding: 10px;

  }
  .logoutbtn svg:hover{
   
    color: #0d6efd;
   

  }
@media screen and (max-width:990px){
  .logoutbtn{
    margin: 5px 0px 0 0px;
  }

}

</style>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a style="font-size: 25px;" class="navbar-brand" href="index.php">CS.Mini Shop</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li>
          <form action="#" method="post">

            <input type="text" style="padding: 0px 10px; margin-top: 7px; border-radius:100px; font-size:20px;" name="input" placeholder="Type item name...">
 
            <input class="btn btn-primary" style="margin-top: -3px; padding:1px 8px; border-radius:100px;font-size:20px;" type="submit" name="search" value="Search">

          </form>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php">Home</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Category
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <?php foreach ($categories as $category) :  ?>
              <li><a class="dropdown-item" href="category.php?category_keyword=<?php echo $category['CategoryTitle'];  ?>"><?php echo $category['CategoryTitle'];  ?></a></li>

              <li>
                <hr class="dropdown-divider" />
              </li>
            <?php endforeach; ?>

          </ul>

        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Quick Link
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">

            <li>
              <a class="dropdown-item" href="AddItemPage.php">Sell an item!</a>
            </li>
            <li>
                <hr class="dropdown-divider" />
              </li>
            <li><a class="dropdown-item" href="EditItemPage.php">Edit your item</a></li>
            <li>
              <hr class="dropdown-divider" />
              </li>
            <li><a class="dropdown-item" href="purchasedhistory.php">Purchase History</a></li>
            <li>
              <hr class="dropdown-divider" />
            </li>
            <div class="<?php echo $_SESSION['userrole']; ?>">
            <li><a class="dropdown-item" href="AddHelpSection.php">Add Help Section Question</a></li>
            <li>
              <hr class="dropdown-divider" />
            </li>
            <li><a class="dropdown-item" href="EditDeleteHelpSection.php">Edit and Delete Help Section Question</a></li>
            <li>
              <hr class="dropdown-divider" />
            </li>
            </div>
          </ul>

        </li>
        <li class="nav-item">
          <a class="nav-link" href="AboutUs.php">About Us</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="ContactUs.php">Contact Us</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="Helpsection.php">Help Section</a>
        </li>

        <li class="nav-item">
          <!-- ADD PROFILE LINK HERE-->
          <div style="margin: auto;">
          <a href="user_profile.php">
            <i class="far fa-user-circle" style='font-size:50px; padding-left: 10px; border-radius:100px;'></i>
            </a>
            </div>
        </li>
        <li class="nav-item">
         <div class="logoutbtn">
          <a onclick="return confirm('Are you sure you want to log out?')" href="Logout.php"><svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z"/>
  <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
</svg></a>
          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>