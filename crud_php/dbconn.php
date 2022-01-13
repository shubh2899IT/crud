<?php
    define("servername", "localhost");
    define("username", "root");
    define("password", "");
    define("dbname", "sample");

    $conn = mysqli_connect(servername, username, password, dbname) or die ("Connection wrong");
?>