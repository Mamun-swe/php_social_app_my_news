<?php
    session_start();
    ob_start();
    if($_SESSION['userId']){
        $sessionId = $_SESSION['userId'];
        $postId = $_GET['id'];
        echo $postId;
        include('../db/connect.php');
        $sql = "DELETE FROM posts WHERE post_id=$postId";
        if ($conn->query($sql) === TRUE) {
            header('Location: ../views/profile.php');
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    }else{
        header('location: ../index.php');
    }
?>
