<?php
include_once "Php/config.php";
session_start();
if (!isset($_SESSION['user_email'])) {
  header("Location:login.php");
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

if (isset($_POST['edit_faq'])) {
  $faq = strip_tags($_GET['faq']);
  $question = strip_tags($_POST['question']);
  $answer = strip_tags($_POST['answer']);
  $sql = "UPDATE faqs SET questions ='" . $question . "', answer='" . $answer . "' WHERE id='" . $faq . "' LIMIT 1";
  $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
  header("location:Helpsection.php");
  exit();
}
if (isset($_POST['delete_faq'])) {
  $faq = strip_tags($_GET['faq']);
  $sql = "DELETE FROM faqs WHERE id='" . $faq . "' LIMIT 1";
  $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
  header("location:EditDeleteHelpSection.php");
  exit();
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
</style>

<body>
  <?php
  include "Php/header.php";
  ?>
  <div class="row">
    <?php
    include "Php/carticon.php";
    ?>
  </div>
  <?php
  include "Php/sidebar.php";
  ?>

  <?php
  $sql = "SELECT * FROM faqs";
  $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
  if (mysqli_num_rows($res) > 0) {
  ?>

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
                  <span>Add Delete Help Section Page</span>
                </div>
                <?php
                while ($row = mysqli_fetch_assoc($res)) {
                  $id = $row['id'];
                  $questions = $row['questions'];
                  $answer = $row['answer'];
                  echo '<form action="EditDeleteHelpSection.php?faq=' . $id . '" method="post">
              <div class="screen-body-item">
                <div class="app-form">
                  <div class="app-form-group">
                    <span><input type="text" name="question" size="65" placeholder="Question:" value="' . $questions . '">
                    <!--Edit Question here-->                    
                  </div>
                  <div class="app-form-group message">
                    <input placeholder="Answer:" type="text" name="answer" size="65" value="' . $answer . '">
                    <!--Edit answer here-->                
                  </div>
                </div>
                <div class="app-form-group buttons">
                  <button class="app-form-button" type="submit" name="delete_faq">Delete FAQ</button>
                  <button class="app-form-button" type="submit" name="edit_faq">Edit FAQ</button>
                </div>
              </div>
              </form>';
                }
                ?>
              </div>
            <?php
          } else {
            echo "There are no FAQs to edit at this time.";
          }
            ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
    </div>
</body>

</html>