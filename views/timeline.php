<?php
    session_start();
    ob_start();
    $success = "";
    $content = "";
    $file_name = "";
    $content_err = "";
    $file_err = "";
    $limitCross = "";
    include('../db/connect.php');
    if($_SESSION['userId']){
        $sessionId = $_SESSION['userId'];
        // Post status
        if(isset($_POST['submit'])){
            if(empty($_POST['content'])){
                $content_err = "Content is required.";
            } else {
                $content = $_POST['content'];
            }
            if(empty($_FILES['image']['name'])){
               $file_err = "File is required.";
            }else {
                $file_name = $_FILES['image']['name'];
                $file_size = $_FILES['image']['size'];
                $file_tmp = $_FILES['image']['tmp_name'];
                $file_type = $_FILES['image']['type'];
                // move_uploaded_file($file_tmp,"images/".$file_name); 
            }

           
            if(!empty($_POST['content']) && !empty($_FILES['image']['name'])){
                
                $save_post = "INSERT INTO posts (user_id, content, images) VALUES ('$sessionId', '$content', '$file_name')";
                    if($conn->query($save_post) === TRUE) {
                        move_uploaded_file($file_tmp,"images/".$file_name);  
                        $success = "Your post successfully uploaded.";
                    } else {
                        echo "Error";
                    }
                // $select_posts = "SELECT * FROM posts WHERE user_id='$sessionId' ORDER BY post_id DESC LIMIT 1";
                // $result = mysqli_query($conn, $select_posts);
                // while ($row = mysqli_fetch_array($result)){             
                //     $lastPostDate = date("d.m.y", strtotime($row['post_time']));
                //     $presentDate = date("d.m.y");
                //     if($presentDate > $lastPostDate ) {
                //         $content = $_POST['content'];
                //         $userId = $_SESSION['userId'];

                //         $save_post = "INSERT INTO posts (user_id, content, images) VALUES ('$sessionId', '$content', '$file_name')";
                //         if($conn->query($save_post) === TRUE) {
                //         $success = "Your post successfully uploaded.";
                //         } else {
                //         echo "Error";
                //         }
                //         $conn->close();
                //     } else {
                //         $limitCross = "Post limit cross. You can post after 12 hour later.";
                //     }
                // }
            }

            
                    
                // }
                               
            }

            
        
    }else{
        header('location: ../index.php');
    }
?>

<?php include('../templete/head.php'); ?>
<?php 
include('../views/navbar.php'); 
?>

<div class="container custom-timeline pb-4">
    <div class="row">
        <div class="col-12 col-lg-8 m-auto">
            
            <div class="card mb-4 border-0">
                <div class="card-body p-0">
                    <form method="post" enctype="multipart/form-data">
                    <small class="text-danger"><?php echo $content_err; ?></small><br>
                        <small class="text-danger"><?php echo $file_err; ?></small>
                        <small class="text-success"><?php echo $success; ?></small>
                        <small class="text-danger"><?php echo $limitCross; ?></small>
                        <div class="form-group mb-1">
                            <textarea rows="2" class="form-control shadow-none" placeholder="Write something" name="content"></textarea>
                        </div>
                        <input type="file" name="image"></input>
                        <button type="submit" class="btn btn-primary float-right py-0 px-4 shadow-none" name="submit">Post</button>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
    <!-- Posts -->
    <div class="row custom-post">
        <div class="col-12 col-lg-8 m-auto">

            <?php
                include('../db/connect.php');
                $select_posts = "SELECT * FROM posts INNER JOIN users ON posts.user_id=users.user_id ORDER BY post_id DESC";
                $result = mysqli_query($conn, $select_posts);
                while ($row = mysqli_fetch_array($result)){
                    $image = $row['images'];
                    $image_src = "./images/".$image;
            ?>
            <div class="card shadow-sm mb-4 mb-lg-5">
                <div class="card-body pb-0">
                    <div class="custom-user">
                        <a href="./public-profile.php?id=<?php echo $row['user_id']; ?>" class="text-capitalize text-info mb-0"><?php echo $row['user_name']; ?></a>
                        <br>
                        <small class="text-muted">Posted on <?php echo date("d M, Y", strtotime($row['post_time'])); ?></small>
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