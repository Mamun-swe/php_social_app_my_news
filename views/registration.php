<?php
  include("../db/connect.php");
  $exist_err = "";
  $success = "";
  $username_err = $useremail_err = $userpass_err = "";
  $username = $useremail = $userpass = "";
  if(isset($_POST['submit'])) {
    if($_POST['username']) {
      $username = $_POST['username'];
    } else {
      $username_err = "Username is required.";
    }

    if($_POST['useremail']) {
      $useremail = $_POST['useremail'];
    } else {
      $useremail_err = "E-mail is required.";
    }

    if($_POST['userpass']) {
      $userpass = md5($_POST['userpass']);
    } else {
      $userpass_err = "Password is required.";
    }

    if(!empty($_POST['username']) && !empty($_POST['useremail']) && !empty($_POST['userpass'])) {
      $check_user = "SELECT * FROM users WHERE user_email='$useremail'";
      $check_result = mysqli_query($conn, $check_user);
      if(mysqli_num_rows($check_result) > 0) {
        $exist_err = true;
      } else {
        $save_user = "INSERT INTO users (user_name, user_email, user_password) VALUES ('$username', '$useremail', '$userpass')";
        if($conn->query($save_user) === TRUE) {
          $success = true;
        } else {
          echo err;
        }
        // $conn->close();
      }
    }



  }
?>


<?php include("../templete/head.php"); ?>
 
 <div class="login">
 <div class="flex-center flex-column">
   <div class="card border-0">
     <div class="card-header border-0 text-center">
       <h1>myChat</h1>
       <p>Create an account</p>
     </div>
     <div class="card-body">
      <?php
        if($success){
          echo "<div class='alert alert-success' role='alert'>";
          echo "Successfully account created";
          echo "</div>";
        }
      ?>
      <?php
        if($exist_err){
          echo "<div class='alert alert-danger' role='alert'>";
          echo "This account already created";
          echo "</div>";
        }
      ?>
      
       <form method="post">
       <div class="form-group">
           <small class="text-muted">Username</small>
           <input type="text" class="form-control shadow-none" placeholder="Enter username" name="username">
           <small class="text-danger"><?php echo $username_err; ?></small>
         </div>
         <div class="form-group">
           <small class="text-muted">E-mail</small>
           <input type="email" class="form-control shadow-none" placeholder="Enter e-mail" name="useremail">
           <small class="text-danger"><?php echo $useremail_err; ?></small>
         </div>
         <div class="form-group">
           <small class="text-muted">Password</small>
           <input type="password" class="form-control shadow-none" placeholder="Enter password" name="userpass">
           <small class="text-danger"><?php echo $userpass_err; ?></small>
         </div>
         <button type="submit" class="btn btn-block btn-primary py-1 shadow-none" name="submit">Create Account</button>
       </form>

       <div class="link-box py-3 text-center">
         <a href="../index.php">Go to login</a>
       </div>
     </div>
   </div>
 </div>
 </div>

 <?php include("../templete/footer.php"); ?>