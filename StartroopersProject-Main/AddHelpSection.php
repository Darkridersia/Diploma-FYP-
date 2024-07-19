<?php
include_once "Php/config.php";
session_start();
// if user didnt login, bring them to login page
if (!isset($_SESSION['user_email'])) {
    header("Location:login.php");
}
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
// create question and answer coding part
if (isset($_POST['create_faq'])) {

    $question = $_POST['question'];
    $answer = $_POST['answer'];

    $sql = "INSERT INTO faqs(questions, answer) VALUES('$question', '$answer')";
    $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    header("location:Helpsection.php");
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

    .background {
        display: flex;
        min-height: 100vh;
    }

    .container {
        flex: 0 1 700px;
        margin: auto;
        padding: 10px;
    }

    .screen {
        position: relative;
        background: #3e3e3e;
        border-radius: 15px;
    }

    .screen:after {
        content: '';
        display: block;
        position: absolute;
        top: 0;
        left: 20px;
        right: 20px;
        bottom: 0;
        border-radius: 15px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, .4);
        z-index: -1;
    }

    .screen-header {
        display: flex;
        align-items: center;
        padding: 10px 20px;
        background: #4d4d4f;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }

    .screen-header-left {
        margin-right: auto;
    }

    .screen-header-button {
        display: inline-block;
        width: 8px;
        height: 8px;
        margin-right: 3px;
        border-radius: 8px;
        background: white;
    }

    .screen-header-button.close {
        background: #ea1d6f;
    }

    .screen-header-button.maximize {
        background: #e8e925;
    }

    .screen-header-button.minimize {
        background: #74c54f;
    }

    .screen-header-right {
        display: flex;
    }

    .screen-header-ellipsis {
        width: 3px;
        height: 3px;
        margin-left: 2px;
        border-radius: 8px;
        background: #999;
    }

    .screen-body {
        display: flex;
    }

    .screen-body-item {
        flex: 1;
        padding: 50px;
    }

    .screen-body-item.left {
        display: flex;
        flex-direction: column;
    }

    .app-title {
        display: flex;
        flex-direction: column;
        position: relative;
        color: #ea1d6f;
        font-size: 40px;
    }

    .app-title:after {
        content: '';
        display: block;
        position: absolute;
        left: 0;
        bottom: -10px;
        width: 180px;
        height: 4px;
    }

    .app-contact {
        margin-top: 20px;
        font-size: 20px;
        color: #888;
    }

    .app-form-group {
        margin-bottom: 15px;
    }

    .app-form-group.message {
        margin-top: 20px;
    }

    .app-form-group.buttons {
        margin-bottom: 0;
        text-align: right;
    }

    .app-form-control {
        width: 100%;
        padding: 10px 0;
        background: none;
        border: none;
        border-bottom: 1px solid #666;
        color: #ddd;
        font-size: 14px;
        text-transform: uppercase;
        outline: none;
        transition: border-color .2s;
    }



    .app-form-control::placeholder {
        color: #666;
    }

    .app-form-control:focus {
        border-bottom-color: #ddd;
    }

    .app-form-button {
        background: none;
        border: none;
        color: #ea1d6f;
        font-size: 25px;
        cursor: pointer;
        outline: none;
        padding: 5px;
    }

    .app-form-button:hover {
        color: #ea1d6f;
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
                            <span>Add Help Section Questions</span>
                        </div>
                    </div>

                    <div class="screen-body-item">
                        <div class="app-form">
                            <form action="AddHelpSection.php" method="post">
                                <div class="app-form-group">
                                    <!--Add question for help section-->
                                    <input class="app-form-control" type="text" name="question" size="65" placeholder="Question:">
                                </div>
                                <div class="app-form-group">
                                    <!--Add answer for help section-->
                                    <textarea class="app-form-control " type="text" name="answer" size="500" placeholder="Answer:" cols="20" rows="2"></textarea>
                                </div>
                                <div class="app-form-group buttons">
                                    <!-- add your question and answer at here -->
                                    <button type="submit" class="app-form-button" name="create_faq">Add</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>