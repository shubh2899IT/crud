<?php
    session_start();

     if(!isset($_GET['class_id'])){
        header('Location:allclass.php');
    } else {
        include 'dbconn.php';
    }
    $class_id = $_GET['class_id'];
    $sql = "delete from class_tb where class_id = '{$class_id}'";
    $res = mysqli_query($conn, $sql) or die ("Query wrong");
    
    echo "<script>alert('Record deleted successfully!');
            window.location.href = 'allclass.php';
        </script>";
    
    mysqli_close($conn);
?>