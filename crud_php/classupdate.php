<?php
    session_start();
    if(!isset($_SESSION['user_id'])){
        header('Location:index.php');
    } else {
        include 'dbconn.php';
    }
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
                <h2>Update Record</h2>

                <form class="post-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <div class="form-group">
                        <label>Enter class Id</label>
                        <input type="number" name="class_id" 
                        value="<?php if (isset($_POST['class_id'])) echo $_POST['class_id']; ?>" />
                    </div>
                    <input class="submit" type="submit" name="edit" value="Show Details" />
                </form>

                <br/><br/>

                <?php

                if(isset($_POST['edit'])) 
                {
                    
                    $id = $_POST['class_id'];
                    $sql = "select * from class_tb where class_id = '{$id}'";
                   // and user_id = '{$_SESSION['user_id']}'";
                    $res = mysqli_query($conn, $sql) or die ("Query wrong");

                    if(mysqli_num_rows($res) > 0)
                    {  
                        while($row = mysqli_fetch_assoc($res))
                        {
                    ?>
                    <h2>Class Details</h2>
                    <form class="post-form" action="classupdateall.php" method="post" 
                        onsubmit="return confirm('Are you sure?');">
                        <div class="form-group">
                            <input type="hidden" name="cid" id="cid" 
                            value="<?php 
                                if (isset($_POST['cid'])) echo $_POST['cid']; else 
                                echo $row['class_id']; ?>" />
                            
                        </div>
                        <div class="form-group">
                        <label>Class</label>
                        <input type="text" name="sclass" id="sclass" 
                        value="<?php if (isset($_POST['sclass'])) echo $_POST['sclass'];
                        else 
                        echo $row['class_name']; ?>" />
                        
                    </div>
                       
                        <input class="submit" type="submit" name="submit" value="Update" />
                    </form>
                    <?php
                        }
                    } else {
                        echo "No record found";
                    }
                }
                mysqli_close($conn);
                ?>
            </div>
        </div>
    </body>
</html>
