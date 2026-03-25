<?php

require_once 'funcao/Usuario.php';
require_once 'db/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $pdo = conecta();

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['pass'];
    $confirmSenha = $_POST['confirmPass'];

    $userCadastrado = listarUser($pdo);

    foreach ($userCadastrado as $user) {
        if ($user['email'] === $email) {
            header('Location: cadastro.php');
            exit;

        }
    }

    if ($senha !== $confirmSenha) {
        header('Location: cadastro.php');
        exit;
    }

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    cadastroUser($pdo, $nome, $email, $senhaHash);

    header('Location: login.php');

}