<?php
    session_start();

    if(!isset($_SESSION['user_id'])){
        header('Location:index.php');
    } else if(!isset($_GET['stud_id'])){
        header('Location:all.php');
    } else {
        include 'dbconn.php';
    }

    $stud_id = $_GET['stud_id'];
    $stud_photo = $_GET['stud_photo'];
    
    $img_dir = 'upload/';

    $sql = "delete from student_tb where stud_id = '{$stud_id}'
    and user_id = '{$_SESSION['user_id']}'";

    $res = mysqli_query($conn, $sql) or die ("Query wrong");

    if(file_exists($img_dir . $stud_photo)){
        unlink($img_dir . $stud_photo);
    }
    
    echo "<script>alert('Record deleted successfully!');
            window.location.href = 'all.php';
        </script>";
    
    mysqli_close($conn);
?>