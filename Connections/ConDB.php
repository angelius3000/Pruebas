<?php
/* Database connection start */
if ($_SERVER['HTTP_HOST'] == "localhost/edisonreparto") {

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "edison";
} else {

    /* Database connection start */
    $servername = "localhost:3306";
    $username = "root";
    $password = "";
    $dbname = "edison";
}

$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());
/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
