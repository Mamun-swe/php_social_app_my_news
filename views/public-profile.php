<?php
    session_start();
    ob_start();
    $success = "";
    $content = "";
    $content_err = "";
    include('../db/connect.php');
    if($_SESSION['userId']){
        $sessionId = $_SESSION['userId'];
        $userId = $_GET['id'];
        if($userId == $sessionId) {
            header('location: ./profile.php');
        }
    }else{
        header('location: ../index.php');
    }
?>

<?php include('../templete/head.php'); ?>
<?php include('../views/navbar.php'); ?>

<div class="container">
    <div class="row mb-4">
        <div class="col-12 col-lg-8 m-auto">
            <div class="card cover-card">
                <div class="card-body">
                    <div class="flex-center flex-colum">
                    <?php
                        $select_person = "SELECT user_name FROM users  WHERE user_id='$userId'";
                        $result = mysqli_query($conn, $select_person);
                        while ($row = mysqli_fetch_array($result)){
                    ?>
                        <h1 class="text-capitalize mb-0"><?php echo $row['user_name']; ?></h1>
                    <?php
                        }
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <!-- Posts -->
        <div class="row custom-post">
        <div class="col-12 col-lg-8 m-auto">

            <?php
                $select_posts = "SELECT * FROM posts JOIN users ON posts.user_id=users.user_id  WHERE posts.user_id='$userId' ORDER BY post_id DESC";
                $result = mysqli_query($conn, $select_posts);
                while ($row = mysqli_fetch_array($result)){
            ?>
            <div class="card shadow-sm mb-4 mb-lg-5">
                <div class="card-body pb-0">
                    <div class="custom-user">
                        <p class="text-capitalize text-info mb-0"><?php echo $row['user_name']; ?></p>
                        <small class="text-muted">Posted on <?php echo date("d M, Y", strtotime($row['post_time'])); ?></small> 
                    </div>
                    <div class="custom-user-post pt-4">
                        <p><?php echo $row['content']; ?></p>
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