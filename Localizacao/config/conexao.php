<?php

$conn = new mysqli("localhost","root","","localizacao");

if($conn->connect_error){
die("erro conexão");
}