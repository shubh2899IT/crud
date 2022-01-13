<?php
    session_start();
    if(!isset($_SESSION['user_id'])){
        header('Location:index.php');
    } else {
        include 'dbconn.php';
    }

    if(isset($_POST['submit'])) 
    {

        $name = $_POST['sname'];      // single       
        $mobile = $_POST['smobile'];               
        $address = $_POST['saddress'];       
        $gender = $_POST['sgender'];         
        $education = $_POST['sclass'];   

        $hobbies = $_POST['shobbies']; // array      
   
        // array convert into string
        $hoobiesString = implode("#", $hobbies);    // single

        $fileName =  $_FILES['sphoto']['name'];
        $fileTmpName = $_FILES['sphoto']['tmp_name'];

        $cDir = getcwd();
        $uDir = "/upload/";
        $fileExtAllow = ['jpeg', 'jpg', 'png'];
        $tmp = explode(".", $fileName);
        $fileExt = strtolower(end($tmp));
        $uploadPath = $cDir . $uDir . basename($fileName); // full path

        if(!in_array($fileExt, $fileExtAllow)){
            echo "<script>alert('Select image only');</script>";
        } else {
            $status = move_uploaded_file($fileTmpName, $uploadPath);
            if($status){
                $sql = "INSERT INTO student_tb(stud_name, stud_mobile, stud_address, stud_gender, 
                stud_class, stud_hobbies, stud_photo, user_id) VALUES 
                ('{$name}', '{$mobile}', '{$address}', '{$gender}', '{$education}', '{$hoobiesString}', 
                '{$fileName}', '{$_SESSION['user_id']}')";
                $result = mysqli_query($conn, $sql) or die('Query wrong');
                echo "<script>
                    alert('Record is inserted');
                    window.location.href = 'all.php';
                </script>";
            } else {
                echo "<script>alert('File is not uploaded');</script>";
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

    function PreviewImage() {
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("sphoto").files[0]);

        oFReader.onload = function (oFREvent) {
            document.getElementById("uploadPreview").src = oFREvent.target.result;
        };
    };

</script>

    </head>
    <body>
        <div id="wrapper">
            
            <?php include "menu.php"; ?>

            <div id="main-content">
                <h2>Add Record</h2>
                <form class="post-form" action="add.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="sname" id="sname" 
                        value="<?php if (isset($_POST['sname'])) echo $_POST['sname']; ?>" />
                    </div>
                    <div class="form-group">
                        <label>Mobile No</label>
                        <input type="number" name="smobile" id="smobile" 
                        value="<?php if (isset($_POST['smobile'])) echo $_POST['smobile']; ?>" />
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <textarea name="saddress" id="saddress" rows="4" cols="41"><?php if (isset($_POST['saddress'])) echo $_POST['saddress']; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Gender</label>
                        <input type="radio" id="gender_male" name="sgender" value="Male" style="width:10%; margin-left: -15px;"
                        <?php if(isset($_POST['sgender']) && $_POST['sgender'] == 'Male') echo 'checked="checked"';?>
                        > Male
                        <input type="radio" id="gender_female" name="sgender" value="Female" style="width:10%; margin-left: 0px;"
                        <?php if(isset($_POST['sgender']) && $_POST['sgender'] == 'Female') echo 'checked="checked"';?>
                        > Female
                    </div>
                    <div class="form-group">
                        <label>Class</label>
                        <select name="sclass" id="sclass">
                            <option value="Select Class" selected disabled>Select Class</option>
                            <?php
                            $sql = "select * from class_tb";
                            $result = mysqli_query($conn, $sql) or die('Query wrong');

                            while($row = mysqli_fetch_assoc($result))
                            {
                            ?>
                                <option value="<?php echo $row['class_id']; ?>"
                                <?php if (isset($_POST['sclass']) && $_POST['sclass'] == $row['class_id']) 
                                    echo "selected";
                                ?>
                                >
                                <?php echo $row['class_name']; ?></option>
                            <?php
                            }
                            // mysqli_close($conn);
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Hobbies</label>
                        <input type="checkbox" id="reading" name="shobbies[]" value="Reading" 
                        style="width:10%; margin-left: -15px;"
                        <?php if (isset($_POST['shobbies']) && in_array("Reading", $_POST['shobbies']))
                                echo 'checked="checked"';
                        ?>
                        > Reading
                        <input type="checkbox" id="writing" name="shobbies[]" value="Writing" 
                        style="width:10%; margin-left: -5px;"
                        <?php if (isset($_POST['shobbies']) && in_array("Writing", $_POST['shobbies']))
                                echo 'checked="checked"';
                        ?>
                        > Writing
                        <input type="checkbox" id="playing" name="shobbies[]" value="Playing"
                        style="width:10%; margin-left: -5px;"
                        <?php if (isset($_POST['shobbies']) && in_array("Playing", $_POST['shobbies']))
                                echo 'checked="checked"';
                        ?>
                        > Playing
                    </div>
                    <div class="form-group">
                        <label>Photo</label>
                        <input type="file" id="sphoto" name="sphoto">
                    </div>
                    <br/>
                    <input class="submit" type="submit" name="submit" value="Save"  />
                    <input class="submit" type="reset" name="reset" value="Reset"  />
                </form>
            </div>
        </div>
    </body>
</html>
