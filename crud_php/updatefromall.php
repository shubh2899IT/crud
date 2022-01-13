<?php
session_start();

    if(!isset($_SESSION['user_id'])){
        header('Location:index.php');
    } else if(!isset($_POST['sid'])){
        header('Location:all.php');
    } else {
        include 'dbconn.php';
    }

    if(isset($_POST['submit'])) 
    {
        $id = $_POST['sid'];    
        $name = $_POST['sname'];             
        $mobile = $_POST['smobile'];               
        $address = $_POST['saddress'];       
        $gender = $_POST['sgender'];         
        $education = $_POST['sclass'];   

        $hobbies = $_POST['shobbies'];    // array 
   
        // array convert into string
        $hoobiesString = implode("#", $hobbies);

        $fileName =  $_FILES['sphoto']['name'];
        $fileTmpName = $_FILES['sphoto']['tmp_name'];

        $currentphoto = $_POST['currentphoto'];

        $cDir = getcwd();
        $uDir = "/upload/";
        $fileExtAllow = ['jpeg', 'jpg', 'png'];

        if($fileName != ''){
            $tmp = explode(".", $fileName);
            $fileExt = strtolower(end($tmp));
            $uploadPath = $cDir . $uDir . basename($fileName); // full path
        } else {
            $tmp = explode(".", $currentphoto);
            $fileExt = strtolower(end($tmp));
        }
        
        if(!in_array($fileExt, $fileExtAllow)){
            echo "<script>alert('Select image only');</script>";
        } else {
            if($fileName == ''){
                $status = true;
                $fileName = $currentphoto;
            } else {
                $status = move_uploaded_file($fileTmpName, $uploadPath);
            }
            
            if($status){
                $sql = "UPDATE student_tb SET stud_name='{$name}', stud_mobile='{$mobile}',
                stud_address='{$address}', stud_gender='{$gender}', stud_class='{$education}', 
                stud_hobbies='{$hoobiesString}', stud_photo='{$fileName}', user_id='{$_SESSION['user_id']}'
                WHERE stud_id='{$id}'";

                $res = mysqli_query($conn, $sql) or die ("Query wrong");

                if(mysqli_affected_rows($conn)){
                    echo "<script>alert('Record updated successfully!');
                        window.location.href = 'all.php';
                    </script>";
                } else {
                    echo "<script>alert('Values are not changed!');
                    window.location.href = 'all.php';
                    </script>";
                }

            } else {
                echo "<script>alert('File is not uploaded');</script>";
            }
        }
    }
    mysqli_close($conn)
?>