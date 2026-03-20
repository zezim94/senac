<?php

function conexao()
{

    $server = "localhost";
    $user = "root";
    $pass = '';
    $db = "helpdesk";

    try {

        $conn = new PDO("mysql:host=$server; dbname=$db;charset=utf8", $user, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn;
    } catch (PDOException $e) {

        die("Erro na conexão: " . $e->getMessage());

    }


}
