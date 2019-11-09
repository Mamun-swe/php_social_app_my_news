<?php
    session_start();
    ob_start();
    if($_SESSION['userId']){
        $sessionId = $_SESSION['userId'];
    }else{
        header('location: ../index.php');
    }
?>

<?php include("../templete/head.php"); ?>
<?php include('../views/navbar.php'); ?>
<?php
    include('../db/connect.php');
    $success="";
    $comment_err="";
    $postId = $_GET['id'];
    if(isset($_POST['submit'])) {
        if(empty($_POST['comment'])) {
            $comment_err="Comment is required.";
        } else {
            $comment = $_POST['comment'];
            $userId = $_SESSION['userId'];
            
            $save_comment = "INSERT INTO comments (user_id, post_id, content) VALUES ('$userId', '$postId', '$comment')";
            if($conn->query($save_comment) === TRUE) {
                $success = "Your comment posted success.";
            } else {
                echo "Error";
            }
        }
    }
   
   
      
?>

<div class="container custom-comment">
    <div class="row">
        <div class="col-12 col-lg-8 m-auto">
            <div class="card border-0">
                <div class="card-body px-0 px-sm-3">
                
                <?php
                $postId = $_GET['id'];
                include('../db/connect.php');
                $select_posts = "SELECT * FROM posts WHERE post_id='$postId'";
                $result = mysqli_query($conn, $select_posts);
                while ($row = mysqli_fetch_array($result)){
                    $image = $row['images'];
                    $image_src = "./images/".$image;
                ?>
                
                <p class="mb-0 pb-3 border-bottom"><?php echo $row['content']; ?></p>
                <img src='<?php echo $image_src;  ?>' class="img-fluid">
                <?php  
                }
                // Comment count
                $cnt =  "SELECT * FROM comments WHERE post_id='$postId'";
                $check_result = mysqli_query($conn, $cnt);
                $total = mysqli_num_rows($check_result);
                ?>
                <div class="cout-box py-2">
                    <small class="text-muted"><?php echo $total; ?> Pepole commented</small>
                </div>

                <form method="post">
                    <textarea rows="2" class="form-control shadow-none" placeholder="Your comment" name="comment"></textarea>
                    <small class="text-danger"><?php echo $comment_err; ?></small>
                    <small class="text-success"><?php echo $success; ?></small>
                    <button type="submit" class="btn btn-primary py-0 shadow-none float-right mt-1" name="submit">post</button>
                </form>
                <!-- Fetch comments -->
                <div class="py-4">
                    <?php
                    $select_posts = "SELECT * FROM comments JOIN users ON comments.user_id=users.user_id  WHERE comments.post_id='$postId' ORDER BY comment_id DESC";
                    $result = mysqli_query($conn, $select_posts);
                    while ($row = mysqli_fetch_array($result)){
                    ?>

                    <div class="comment pb-2 mb-2">
                        <a href="./public-profile.php?id=<?php echo $row['user_id']; ?>" class="text-info text-capitalize mb-0"><?php echo $row['user_name']; ?></a>
                        <p class="mb-0"><?php echo $row['content']; ?></p>
                    </div>
                    <?php 
                    }
                    ?>

                </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php include("../templete/footer.php"); ?>