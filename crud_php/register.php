<?php
    session_start();
    include 'dbconn.php';
    if(isset($_POST['submit'])) 
    {
        if(empty($_POST['uname']) || empty($_POST['umobile']) ||empty($_POST['upin']))
        
        echo "<script>alert('enter details');</script>";
        
        else
      {
        $name = $_POST['uname'];
        $mobile = $_POST['umobile'];  
        $pin = $_POST['upin'];   

          $query = mysqli_query($conn,"SELECT user_mobile FROM user_tb WHERE user_mobile=$mobile");
             if (mysqli_num_rows($query) != 0)
            {
            //echo "mobile no already exists";
            echo "<script>alert('mobile no already exists');</script>";
             }

            else
           {
               $sql="insert into user_tb(user_name,user_mobile,user_pin) values('$name','$mobile','$pin')";
                  if(mysqli_query($conn,$sql))
                  {
                     echo "<script>alert('Register successfully');
                     window.location.href='index.php';
                     
                     </script>";
                   } 
                   else
                   {
                     echo"error";
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
    </head>
    <body>
        <div id="wrapper">
        <div id="header">
            <h1>CRUD Operation</h1>
        </div>
            <?php //include "menu.php"; ?>

            <div id="main-content">
                <h2 >Register Form</h2>
                <form class="post-form" action="register.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>UserName</label>
                        <input type="text" name="uname" id="uname" 
                        value="<?php if (isset($_POST['uname'])) echo $_POST['uname']; ?>" />
                    </div>
                    <div class="form-group">
                        <label>Mobile No</label>
                        <input type="number" name="umobile" id="umobile" 
                        value="<?php if (isset($_POST['umobile'])) echo $_POST['umobile']; ?>" />
                    </div>
                    <div class="form-group">
                   <label>User Pin</label>
                   <input type="number" name="upin" id="upin" 
                    value="<?php if (isset($_POST['upin'])) echo $_POST['upin']; ?>" />
                    </div>
                    <br/>
                    <input class="submit" type="submit" name="submit" value=" submit"  />
                    <input class="submit" type="reset" name="reset" value="Reset"  />
                </form>
                
            </div>
        </div>
    </body>
</html>
