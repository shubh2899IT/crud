<?php
    session_start();

    if(!isset($_SESSION['user_id'])){
       header('Location:index.php');
    } else {
       include 'dbconn.php';
 }


     $sql= "select * from class_tb";
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
                <h2>All Records</h2>
            <?php
                if(mysqli_num_rows($res) > 0)
                {  
            ?>
                <table cellpadding="7px">
                    <thead>
                    <th>Id</th>
                    <th>Class</th>
                    <th>Action</th>
                    </thead>
                    <tbody>
                        <?php
                            while($row = mysqli_fetch_assoc($res))
                            {
                        ?>
                        <tr>
                            <td style="text-align:center;"><?php echo $row['class_id']; ?></td>
                           
                            <td style="text-align:center;"><?php echo $row['class_name']; ?></td>
                            <td>
                                <a onclick="return confirm('Are You Sure?')" href='classedit.php?class_id=<?php echo $row['class_id']; ?>'>Edit</a>
                                <a onclick="return confirm('Are You Sure?')" href='classdeleteall.php?class_id=<?php echo $row['class_id']; ?>'>Delete</a>
                            </td>
                        </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
                <?php
                } else {
                    echo "No record found";
                }
                mysqli_close($conn);
                ?>
            </div>
        </div>
    </body>
</html>
