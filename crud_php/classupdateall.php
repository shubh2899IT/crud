<?php
session_start();

    if(!isset($_SESSION['user_id'])){
      header('Location:index.php');
    } else 
    if(!isset($_POST['cid'])){
        header('Location:allclass.php');
   } else {
        include 'dbconn.php';
    }

    if(isset($_POST['submit'])) 
    {
       $id1 = $_POST['cid'];    
        $edu = $_POST['sclass'];  
        $sql=mysqli_query($conn,"SELECT class_name FROM class_tb WHERE class_name='{$edu}'");
      
        if (mysqli_num_rows($sql)>0)
       {
       
       echo "<script>alert('class name already exists');
       window.location.href = 'classupdate.php';
       </script>";
       
        }
   else
    {
                $sql= "UPDATE `class_tb` SET `class_name` = '$edu' WHERE `class_tb`.`class_id` = '$id1'";
                $res = mysqli_query($conn, $sql) or die ("Query wrong");

                if(mysqli_affected_rows($conn)){
                    echo "<script>alert('Record updated successfully!');
                        window.location.href = 'allclass.php';
                    </script>";
                } else {
                    echo "<script>alert('Values are not changed!');
                    window.location.href = 'allclass.php';
                    </script>";
                }

     } 
        
    }
    mysqli_close($conn)
?>