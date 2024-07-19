<?php
session_start();
include('server.php');

?>
<!DOCTYPE html>
<html>

<head>

  <title>CS.Mini Shop</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
  <link rel="stylesheet" type="text/css" href="Externalstylesheet/style3.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- google font-->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Glory:wght@500&display=swap" rel="stylesheet">
  <!-- google font-->

  <!-- For password eye icon -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />


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

    body,
    button,
    input,
    textarea,
    select,
    option {
      font-family: 'Montserrat', sans-serif;
      font-weight: 700;
      letter-spacing: 1.4px;
    }
  </style>

</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a style="font-size:25px;" class="navbar-brand" href="index.php">CS.Mini Shop</a>


    </div>
  </nav>

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
              <span>Login</span>
            </div>

            <div>
              <form action="login.php" id="server-form" method="post">

                <div class="screen-body-item">
                  <div class="app-form">
                    <div class="app-form-group">
                      <input class="app-form-control" PLACEHOLDER="Student Email" id="user_email" type="text" name="user_email" required>
                    </div>

                    <div class="app-form-group">
                      <input class="app-form-control" PLACEHOLDER="Password" id="user_password" type="password" name="user_password" required>
                      <i style="color: blanchedalmond;" class="bi bi-eye-slash" id="togglePassword"></i>
                    </div>
                    <br>
                    <div class="app-form-group buttons">
                      <input style="   font-family: 'Glory', sans-serif;" class="btn btn-primary" type="submit" id="login" name="login_user" value="Login">
                    </div>
                    <div class="app-form-group buttons">
                      <a href="register.php?page=user" class="btn btn-primary" style="float:left; margin-top: -20%;">Register</a>
                    </div>
                    <div>
                      <p><a href="change_password(type_email).php?page=user">Forgot_password</a></p>
                    </div>
                  </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </form>

  </div>

</body>

</html>

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
</script>