<?php
/* Database connection start */
if ($_SERVER['HTTP_HOST'] == "localhost") {

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "edisonincidenciasp";
} else if ($_SERVER['HTTP_HOST'] == "local.edison:8888") {

    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "edison";
} else {

    /* Database connection start */
    $servername = "localhost:3306";
    $username = "sistemas";
    $password = "Edison2024!";
    $dbname = "edisonincidenciasp";
}

$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());
/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
