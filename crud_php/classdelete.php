<?php
    session_start();
    if(!isset($_SESSION['user_id'])){
        header('Location:index.php');
    } else {
        include 'dbconn.php';
    }

    if(isset($_POST['delete'])) 
    {
        $class_id = $_POST['class_id'];
       
        $sql = "delete from class_tb where class_id = '{$class_id}'";
        $res = mysqli_query($conn, $sql) or die ("Query wrong");

        if(mysqli_affected_rows($conn)){
            echo "<script>alert('Record deleted successfully!');
                    window.location.href = 'allclass.php';
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
            
            <?php include "menu1.php"; ?>
            
            <div id="main-content">
                <h2>Delete Record</h2>
                <form class="post-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"
                    onsubmit="return confirm('Are you sure?');">
                    <div class="form-group">
                        <label>Enter class Id</label>
                        <input type="number" name="class_id" 
                        value="<?php if (isset($_POST['class_id'])) echo $_POST['class_id']; ?>" />
                    </div>
                    <input class="submit" type="submit" name="delete" value="Delete Record" />
                </form>
            </div>
        </div>
    </body>
</html>
