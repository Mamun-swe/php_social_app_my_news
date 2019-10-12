
<?php include("../templete/head.php"); ?>
<?php
  $email_err = $pass_err = "";
  $email = $password = "";
  $not_found = "";
  $success = "";
  if(isset($_POST['submit'])){
    if(empty($_POST['email'])) {
      $email_err = "E-mail is requred.";
    } else {
    $email = $_POST['email'];
    }

    if(empty($_POST['newpassword'])) {
      $pass_err = "New password is requred.";
    } else {
    $password = md5($_POST['newpassword']);
    }

    if(!empty($_POST['email']) && !empty($_POST['newpassword'])) {
      include("../db/connect.php");
      $check_account = "SELECT * FROM users WHERE user_email='$email'";
      $check_result = mysqli_query($conn, $check_account);
      if(mysqli_num_rows($check_result) > 0) {

        $sql = "UPDATE users SET user_password='$password' WHERE user_email='$email'";

          if ($conn->query($sql) === TRUE) {
            $success = "Password successfully updated.";
          } else {
            echo "Error updating record: " . $conn->error;
          }
          $conn->close();

      } else {
        $not_found = "Account not found.";
      }
    }
  }
?>
 
 <div class="login">
 <div class="flex-center flex-column">
   <div class="card border-0">
     <div class="card-header border-0 text-center">
       <h1>myChat</h1>
       <p class="mb-0">Reset password</p>
       <p class="text-success"><?php echo $success; ?></p>
       <p class="text-danger"><?php echo $not_found; ?></p>
     </div>
     <div class="card-body">
       <form method="post">
         <div class="form-group">
           <small class="text-muted">E-mail</small>
           <input type="text" class="form-control shadow-none" placeholder="E-mail" name="email">
           <small class="text-danger"><?php echo $email_err; ?></small>
         </div>
         <div class="form-group">
           <small class="text-muted">New password</small>
           <input type="password" class="form-control shadow-none" placeholder="New password" name="newpassword">
           <small class="text-danger"><?php echo $pass_err; ?></small>
         </div>
         <button type="submit" class="btn btn-block btn-primary py-1 shadow-none" name="submit">Reset Now</button>
       </form>
       <div class="link-box py-3 text-center">
         <a href="../index.php">Go to login</a>
       </div>
     </div>
   </div>
 </div>
 </div>

 <?php include("../templete/footer.php"); ?>