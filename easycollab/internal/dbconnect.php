<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "easycollab";

if(!$con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname))
{
    die("Failed to connect to database");
}
?>