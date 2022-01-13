<?php
    session_start();
    if(!isset($_SESSION['user_id'])){
        header('Location:index.php');
    } else {
        include 'dbconn.php';
    }

    $imgDir = "upload/";
    $stud_id = $_GET['stud_id'];
    $sql = "select * from student_tb where stud_id = '{$stud_id}'
    and user_id = '{$_SESSION['user_id']}'";
    $res = mysqli_query($conn, $sql) or die ("Query wrong");
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
                <?php
                if(mysqli_num_rows($res) > 0)
                {  
                    while($row = mysqli_fetch_assoc($res))
                    {
                ?>
                <form class="post-form" action="updatefromall.php" method="post" enctype="multipart/form-data"
                onsubmit="return confirm('Are you sure?');">
                    <div class="form-group">

                        <input type="hidden" name="sid" id="sid" 
                        value="<?php 
                            if (isset($_POST['sid'])) 
                                echo $_POST['sid']; 
                            else 
                                echo $row['stud_id']; ?>" />


                        <label>Name</label>
                        <input type="text" name="sname" id="sname" 
                        value="<?php 
                            if (isset($_POST['sname'])) 
                                echo $_POST['sname']; 
                            else 
                                echo $row['stud_name']; ?>" />
                    </div>
                    <div class="form-group">
                        <label>Mobile No</label>
                        <input type="number" name="smobile" id="smobile" 
                        value="<?php 
                            if (isset($_POST['smobile'])) echo $_POST['smobile']; else 
                            echo $row['stud_mobile']; ?>" />
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <textarea name="saddress" id="saddress" rows="4" cols="41"><?php if (isset($_POST['saddress'])) echo $_POST['saddress']; else echo $row['stud_address']; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Gender</label>
                        <input type="radio" id="gender_male" name="sgender" value="Male" style="width:10%; margin-left: -15px;"
                        <?php if((isset($_POST['sgender']) && $_POST['sgender'] == 'Male') || $row['stud_gender'] == 'Male') 
                            echo 'checked="checked"'; ?>
                        > Male
                        <input type="radio" id="gender_female" name="sgender" value="Female" style="width:10%; margin-left: 0px;"
                        <?php if(isset($_POST['sgender']) && $_POST['sgender'] == 'Female' || $row['stud_gender'] == 'Female') echo 'checked="checked"';?>
                        > Female
                    </div>
                    <div class="form-group">
                        <label>Class</label>
                        <select name="sclass" id="sclass">
                            <option value="Select Class" selected disabled>Select Class</option>
                            <?php
                            $sql = "select * from class_tb";
                            $result = mysqli_query($conn, $sql) or die('Query wrong');

                            while($classrow = mysqli_fetch_assoc($result))
                            {
                            ?>
                                <option value="<?php echo $classrow['class_id']; ?>"
                                <?php if ((isset($_POST['sclass']) && $_POST['sclass'] == $classrow['class_id']) ||
                                    $classrow['class_id'] == $row['stud_class']) 
                                    echo "selected";
                                ?> >
                                <?php echo $classrow['class_name']; ?></option>
                            <?php
                            }
                            // mysqli_close($conn);
                            ?>
                        </select>
                    </div>
                    <div class="form-group">

                        <?php
                            $data = explode("#", $row['stud_hobbies']); // string -> array
                        ?>

                        <label>Hobbies</label>
                        <input type="checkbox" id="reading" name="shobbies[]" value="Reading" 
                        style="width:10%; margin-left: -15px;"
                        <?php if ((isset($_POST['shobbies']) && in_array("Reading", $_POST['shobbies']))
                                || in_array("Reading", $data))
                                echo 'checked="checked"';
                        ?>
                        > Reading
                        <input type="checkbox" id="writing" name="shobbies[]" value="Writing" 
                        style="width:10%; margin-left: -5px;"
                        <?php if ((isset($_POST['shobbies']) && in_array("Writing", $_POST['shobbies']))
                                || in_array("Writing", $data))
                                echo 'checked="checked"';
                        ?>
                        > Writing
                        <input type="checkbox" id="playing" name="shobbies[]" value="Playing"
                        style="width:10%; margin-left: -5px;"
                        <?php if ((isset($_POST['shobbies']) && in_array("Playing", $_POST['shobbies']))
                                || in_array("Playing", $data))
                                echo 'checked="checked"';
                        ?>
                        > Playing
                    </div>
                    <div class="form-group">
                        <label>Current Photo</label>
                        <img src="<?php echo $imgDir . $row['stud_photo']; ?>" 
                                alt="<?php echo $row['stud_name']; ?>" width="75" height="75" />
                                
                                <input type="hidden" name="currentphoto" id="currentphoto" 
                                value="<?php if (isset($_POST['currentphoto'])) echo $_POST['currentphoto']; else 
                                        echo $row['stud_photo']; ?>" />
                    </div>
                    <div class="form-group">
                        <label>New Photo</label>
                        <input type="file" id="sphoto" name="sphoto">
                    </div>
                    <br/>
                    <input class="submit" type="submit" name="submit" value="Update" />
                </form>
                <?php
                    }
                } else {
                    echo "No record found";
                }
                mysqli_close($conn);
                ?>
            </div>
        </div>
    </body>
</html>
