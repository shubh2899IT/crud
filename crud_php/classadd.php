<?php
    session_start();
    if(!isset($_SESSION['user_id'])){
       header('Location:index.php');
    } else {
        include 'dbconn.php';
    }

    if(isset($_POST['submit'])) 
    {       
        if(empty($_POST['sclass']))
        echo "<script>alert('enter your class');</script>";
        else
        {
        $education = $_POST['sclass']; 
        
        $sql=mysqli_query($conn,"SELECT class_name FROM class_tb WHERE class_name='{$education}'");
      
             if (mysqli_num_rows($sql)>0)
            {
            
            echo "<script>alert('class name already exists');</script>";
             }
        else
         {
            $query = "insert into class_tb(class_name) values('$education')";
            if( mysqli_query($conn,$query))
           {
            echo "<script>
            alert('Record is inserted');
            window.location.href ='allclass.php';
            </script>";
           }

            else{
                echo "error";
            }
        }
        
    }
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

    <script type="text/javascript">
</script>

    </head>
    <body>
        <div id="wrapper">
            
            <?php include "menu1.php"; ?>

            <div id="main-content">
                <h2>Add Record</h2>
                <form class="post-form" action="classadd.php" method="post" enctype="multipart/form-data">
                    
                    <div class="form-group">
                        <label>Class</label>
                        <input type="text" name="sclass" id="sclass" 
                        value="<?php if (isset($_POST['sclass'])) echo $_POST['sclass']; ?>" />
                    </div>
                    <input class="submit" type="submit" name="submit" value="Save"  />
                    <input class="submit" type="reset" name="reset" value="Reset"  />
                </form>
            </div>
        </div>
    </body>
</html>
