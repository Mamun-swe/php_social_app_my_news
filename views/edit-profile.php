<?php
    session_start();
    ob_start();
    $success = "";
    $newName = $newPass = $file_name = "";
    $name_err = $pass_err = $file_err = "";
    if($_SESSION['userId']){
        $sessionId = $_SESSION['userId'];
        if(isset($_POST['update'])){
            if(empty($_POST['newname'])){
                $name_err = "Name is required.";
            } else {
                $newName = $_POST['newname'];
            }

            if(empty($_POST['newpassword'])){
                $pass_err = "Name is required.";
            } else {
                $newPass = md5($_POST['newpassword']);
            }

            if(empty($_FILES['image']['name'])){
                $file_err = "File is required.";
            }else {
                $file_name = $_FILES['image']['name'];
                $file_size = $_FILES['image']['size'];
                $file_tmp = $_FILES['image']['tmp_name'];
                $file_type = $_FILES['image']['type'];
            }


            if(!empty($_POST['newname']) && !empty($_POST['newpassword']) && !empty($_FILES['image']['name'])){
                include('../db/connect.php');
                $sql = "UPDATE users SET user_name='$newName', user_password='$newPass', profile_image='$file_name' WHERE user_id='$sessionId'";

                if ($conn->query($sql) === TRUE) {
                    move_uploaded_file($file_tmp,"profile_images/".$file_name);  
                    $success = "Profile successfully updated.";
                } else {
                    echo "Error updating record: " . $conn->error;
                }
                $conn->close();
            }

        }
        



    } else {
        header('location: ../logout.php');
    }
?>

<?php include("../templete/head.php"); ?>
<?php include('../views/navbar.php'); ?>


<div class="edit-profile">

    <div class="card">
        <div class="card-header text-center py-4">
            <h5 class="mb-0">Update profile</h5>
        </div>
        <div class="card-body">
            <p class="text-success"><?php echo $success; ?></p>
            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <small class="text-muted">Name</small>
                    <br>
                    <small class="text-danger"><?php echo $name_err; ?></small>
                    <input type="text" class="form-control" name="newname" placeholder="Your name">
                </div>
                <div class="form-group">
                <small class="text-muted">New password</small>
                <br>
                    <small class="text-danger"><?php echo $pass_err; ?></small>
                    <input type="password" class="form-control" name="newpassword" placeholder="New password">
                </div>
                <div>
                <small class="text-muted">Profile picture</small>
                <br>
                <input type="file" name="image">
                <br>
                <small class="text-danger"><?php echo $file_err; ?></small>
                </div>
                <button type="submit" name="update" class="btn btn-info float-right py-1">Update Profile</button>
            </form>
        </div>
</div>
</div>






<?php include("../templete/footer.php"); ?>