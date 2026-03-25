<?php

require_once 'funcao/Usuario.php';
require_once 'db/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $pdo = conecta();

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['pass'];
    $confirmSenha = $_POST['confirmPass'];


    if($senha !== $confirmSenha) return;

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    cadastroUser($pdo, $nome, $email, $senhaHash);

    header('Location: login.php');

}