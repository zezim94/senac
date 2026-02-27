<?php

function conexao()
{

    $server = "localhost";
    $user = "root";
    $pass = '';
    $db = "helpdesk";

    $conn = mysqli_connect($server, $user, $pass, $db);

    if (!$conn) {

        die("Error na conexão: " . mysqli_connect_error());
    }

    return $conn;
}