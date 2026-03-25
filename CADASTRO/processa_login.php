<?php

require_once 'DB/conexao.php';
require_once 'funcao/Login.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo = conecta();
    $email = $_POST['email'];
    $senha = $_POST['pass'];

    $stmt = $pdo->prepare("SELECT * FROM `user` WHERE email = :email");
    $stmt->execute(['email' => $email]);

    $user = Login($pdo, $senha, $email);

    if ($user) {

        session_start();
        $_SESSION['user'] = $user['nome'];
        $_SESSION['id'] = $user['id'];

        header('Location: usuario.php');
        exit;

    }

}