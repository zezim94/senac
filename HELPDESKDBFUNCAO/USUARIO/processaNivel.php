<?php

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    require_once '../conexao.php';
    $conn = conexao();

    $nivel = $_POST['nivel'];
    $id = $_POST['id'];

    $stmt = $conn->prepare("UPDATE user SET nivel = :nivel WHERE id = :id");

    return $stmt->execute([
        'nivel' => $nivel,
        'id' => $id
    ]);

  
}