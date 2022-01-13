<?php
    session_start();
    if(!isset($_SESSION['user_id'])){
        header('Location:index.php');
    } else {
        include 'dbconn.php';
    }

    if(isset($_POST['delete'])) 
    {
        $stud_id = $_POST['stud_id'];
        $img_dir = 'upload/';
        $query="SELECT stud_photo FROM student_tb WHERE stud_id=$stud_id";
        $res = mysqli_query($conn,$query) or die ("wrong query");
        while($row = mysqli_fetch_assoc($res))
        {
            $photo = $row['stud_photo'];
        }
        
        if(file_exists($img_dir . $photo)){
            unlink($img_dir . $photo);
        }
        $sql = "delete from student_tb where stud_id = '{$stud_id}' and 
        user_id = '{$_SESSION['user_id']}'";

        $res = mysqli_query($conn, $sql) or die ("Query wrong");

        if(mysqli_affected_rows($conn)){
            echo "<script>alert('Record deleted successfully!');
                    window.location.href = 'all.php';
            </script>";
        } else {
            echo "<script>alert('Record not found!');</script>";
        }
    }
    mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CRUD Operation</title>
    <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <div id="wrapper">
            
            <?php include "menu.php"; ?>
            
            <div id="main-content">
                <h2>Delete Record</h2>
                <form class="post-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"
                    onsubmit="return confirm('Are you sure?');">
                    <div class="form-group">
                        <label>Enter student Id</label>
                        <input type="number" name="stud_id" 
                        value="<?php if (isset($_POST['stud_id'])) echo $_POST['stud_id']; ?>" />
                    </div>
                    <input class="submit" type="submit" name="delete" value="Delete Record" />
                </form>
            </div>
        </div>
    </body>
</html>
