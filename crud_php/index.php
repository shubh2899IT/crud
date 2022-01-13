<?php
session_start();
    include 'dbconn.php';

    if(isset($_POST['submit'])){
        if(empty($_POST['smobile'])){
            echo "<script>alert('Enter valid mobile number');</script>";            
        } else if(empty($_POST['spin'])){
            echo "<script>alert('Enter valid PIN');</script>";
        } else {
            $username = $_POST['smobile'];
            $pin = $_POST['spin'];

            $sql = "select * from user_tb where user_mobile = '$username' and user_pin = $pin";
            $res = mysqli_query($conn, $sql) or die ("Query wrong");

            if(mysqli_num_rows($res) > 0){

                $row = mysqli_fetch_assoc($res);
                // Create session variables
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['user_name'] = $row['user_name'];
                
                header("Location: all.php");

            } else {
                
                echo "<script>alert('User not found');</script>";
                //echo "<script>alert('Do not have an account pls register account');</script>";
            
            }
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
        <div id="header">
            <h1>CRUD Operation</h1>
        </div>
        <div id="main-content">
            <h2>Login Form</h2>
            <br/><br/>
            <form class="post-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="form-group" style="padding-left:20%;">
                    <label>Mobile No</label>
                    <input type="text" name="smobile" id="smobile" style="width:40%;" />
                </div>
                <div class="form-group" style="padding-left:20%;">
                    <label>Pin</label>
                    <input type="password" name="spin" id="spin" style="width:40%;" />
                </div>
                <br/>
                    <input class="submit" type="submit" name="submit" value="Login"  />
                    <input class="submit" type="reset" style="margin-left:10%;" value="Reset" /></br></br>
                   <center> <h3>Don't have an account?
            <a href='register.php'>register here</a></h3></center>
                         
            </form>
            
        </div>
    </div>
</body>

</html>