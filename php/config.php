<?php 
    $domain = ""; 
    $host = "localhost";
    $user = "databaseuser"; //Database username
    $pass = "databasepass"; //Database password
    $db = "database"; //Database name

    $conn = mysqli_connect($host, $user, $pass, $db);
    if(!$conn){
        echo "Database connection error".mysqli_connect_error();
    }
?>