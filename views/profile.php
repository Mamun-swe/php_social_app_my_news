<?php
    session_start();
    ob_start();
    if($_SESSION['userId']){
        $sessionId = $_SESSION['userId'];
        include('../db/connect.php');
        $logged_user_name = "";
        $select_user = "SELECT * FROM users WHERE user_id='$sessionId'";
        $result = mysqli_query($conn, $select_user);
        while ($row = mysqli_fetch_array($result)){
           $logged_user_name = $row['user_name'];
           $profileImage = $row['profile_image'];
            $Profile_image_src = "./profile_images/".$profileImage;
        }
    }else{
        header('location: ../logout.php');
    }
?>


<?php include('../templete/head.php'); ?>
<?php include('../views/navbar.php'); ?>


<div class="container">
    <div class="row mb-4">
        <div class="col-12 col-lg-8 m-auto">
            <div class="card cover-card">
                <div class="card-body">
                    <div class="flex-center flex-column">
                        <img src='<?php echo $Profile_image_src;  ?>' class="profile-image rounded-circle">
                        <h1 class="text-capitalize mb-0"><?php echo $logged_user_name; ?></h1>
                        <a href="./edit-profile.php" class="btn btn-sm btn-light rounded-0 shadow-none py-0">Edit profile</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <!-- Posts -->
        <div class="row custom-post">
        <div class="col-12 col-lg-8 m-auto">

            <?php
                include('../db/connect.php');
                $select_posts = "SELECT * FROM posts JOIN users ON posts.user_id=users.user_id  WHERE posts.user_id='$sessionId' ORDER BY post_id DESC";
                $result = mysqli_query($conn, $select_posts);
                while ($row = mysqli_fetch_array($result)){
                    $image = $row['images'];
                    $image_src = "./images/".$image;
            ?>
            <div class="card shadow-sm mb-4 mb-lg-5">
                <div class="card-body pb-0">
                    <div class="custom-user">
                        <div class="d-flex">
                            <div>
                                <p class="text-capitalize text-info mb-0"><?php echo $row['user_name']; ?></p>
                                <small class="text-muted">Posted on <?php echo date("d M, Y", strtotime($row['post_time'])); ?></small>
                            </div>
                            <div class="ml-auto">
                                <a href="../templete/delete-post.php?id=<?php echo $row['post_id']; ?>" class="btn custom-btn px-2 py-1 rounded-circle"><i class="fas fa-trash-alt"></i></a>
                                <a href="./edit-post.php?id=<?php echo $row['post_id']; ?>" class="btn custom-btn px-2 py-1 rounded-circle"><i class="fas fa-pen"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="custom-user-post pt-4">
                        <p><?php echo $row['content']; ?></p>
                        <img src='<?php echo $image_src;  ?>' class="img-fluid">
                    </div>
                </div>
                <div class="card-footer border-0">
                    <div class="d-flex">
                        <div class="ml-auto">
                        <a href="./comment.php?id=<?php echo $row['post_id']; ?>" class="btn shadow-none px-3 py-1 float-right"><i class="far fa-comment-alt mr-2"></i>Comment</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            }
            ?>

        </div>
    </div>

</div>

<?php include('../templete/footer.php'); ?>
