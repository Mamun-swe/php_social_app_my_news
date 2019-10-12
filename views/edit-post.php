<?php
    session_start();
    ob_start();
    if($_SESSION['userId']){
        $sessionId = $_SESSION['userId'];
        include('../db/connect.php');
        $postId = $_GET['id'];
    }else{
        header('location: ../index.php');
    }
?>



<?php include('../templete/head.php'); ?>
<?php include('../views/navbar.php'); ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12 col-lg-8 m-auto">
            <div class="card border-0 px-0 px-sm-3">
                <div class="card-body">
                <?php 
                    $content_err = "";
                    $newContent = "";
                    if(isset($_POST['submit'])) {
                        if(empty($_POST['content'])){
                            $content_err = "Content is required.";
                        } else {
                            $newContent = $_POST['content'];
                            $sql = "UPDATE posts SET content='$newContent' WHERE post_id='$postId'";

                            if ($conn->query($sql) === TRUE) {
                                echo "Record updated successfully";
                                header('Location: ./profile.php');
                            } else {
                                echo "Error updating record: " . $conn->error;
                            }
                            $conn->close();
                        }
                    }
                ?>

                    <form method="post">
                        <div class="form-group">
                            <small class="text-danger"><?php echo $content_err; ?></small>
                            <textarea class="form-control shadow-none" rows="4" name="content" placeholder="Type new content"></textarea>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary shadow-none float-right py-1 px-3">Update</button>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>


<?php include('../templete/footer.php'); ?>