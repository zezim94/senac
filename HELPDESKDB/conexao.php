<?php

$server = "localhost";
$user = "root";
$pass = '';
$db = "helpdesk";

$conn = mysqli_connect($server, $user, $pass, $db);

if($conn){
 
}else{
    die("Error: " . mysqli_connect_error());
}