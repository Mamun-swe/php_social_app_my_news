<?php
    session_start();
    ob_start();
    if($_SESSION['userId']){
        $sessionId = $_SESSION['userId'];
        include('../db/connect.php');
    }else{
        header('location: ../index.php');
    }
?>
<?php include('../templete/head.php'); ?>
<?php include('../views/navbar.php'); ?>
<style>

</style>
<div class="container">
    <div class="row">
        <div class="col-12 col-lg-8 m-auto">
            <div class="card border-0">
                <div class="card-body">
                <?php
                    $empty_err = "";
                    $myVal = "";
                    if(isset($_POST['search'])) {
                        include('../db/connect.php');
                        $myVal = $_POST['searchValue'];
                        $searchUser = "SELECT * FROM users WHERE user_name LIKE '%$myVal%'";
                        $result = mysqli_query($conn, $searchUser);
                         while ($row = mysqli_fetch_array($result)){
                ?>
                    <a href="./public-profile.php?id=<?php echo $row['user_id']; ?>" class="px-2 py-1 d-block searchUserName"><?php echo $row['user_name']; ?></a>
               <?php
                    }
                    }
                ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../templete/footer.php'); ?>