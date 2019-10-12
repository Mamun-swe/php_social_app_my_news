<?php
  session_start();
  ob_start();

  $error = "";
  $email = $password = "";
  $email_err = $pass_err = "";
  if(isset($_POST['submit'])){
    if(empty($_POST['email'])){
      $email_err = "E-mail is required.";
    } else {
      $email = $_POST['email'];
    }
    if(empty($_POST['password'])){
      $pass_err = "Password is required.";
    } else {
      $password = md5($_POST['password']);
    }


    if(!empty($_POST['email']) && !empty($_POST['password'])){
      include("./db/connect.php");
      $check = mysqli_query($conn, "SELECT * FROM users WHERE user_email='$email' AND user_password='$password'");
      $row = mysqli_fetch_array($check);

      if($row['user_email'] == $email && $row['user_password'] == $password) {
        $_SESSION['userId'] = $row['user_id'];
        header('Location: ./views/timeline.php');
        ob_flush();
      } else {
        $error = true;
      }
    }

  }
?>


<!doctype html>
<html lang="en">
  <head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="./css/bootstrap.min.css">
  <link rel="stylesheet" href="./css/global.css">
  <link rel="stylesheet" href="./css/index.css">
  <title>My News</title>
</head>
<body>

 
  <div class="login">
    <div class="flex-center flex-column">
      <div class="card border-0">
        <div class="card-header border-0 text-center">
          <h1>myNews</h1>
          <p>Login account</p>
        </div>
        <div class="card-body">
        <?php
          if($error){
            echo "<div class='alert alert-danger' role='alert'>";
            echo "Username or Password incorrect.";
            echo "</div>";
          }
        ?>
          <form method="post">
            <div class="form-group">
              <small class="text-muted">E-mail</small>
              <input type="text" class="form-control shadow-none" placeholder="E-mail" name="email">
            </div>
            <div class="form-group">
              <small class="text-muted">New password</small>
              <input type="password" class="form-control shadow-none" placeholder="New password" name="password">
            </div>
            <button type="submit" class="btn btn-block btn-primary py-1 shadow-none" name="submit">Login Account</button>
          </form>
          <div class="link-box py-3 text-center">
            <a href="./views/registration.php">Have no account ? Click to create.</a>
            <br>
            <a href="./views/forgot-password.php">Forgot password ?</a>
          </div>
        </div>
      </div>
    </div>
  </div>

    <script src="./js/jquery-3.3.1.slim.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/popper.min.js"></script>
  </body>
</html>