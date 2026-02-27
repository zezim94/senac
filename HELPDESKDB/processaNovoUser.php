<?php
include 'verificaLogin.php';
require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nome = trim($_POST['nome']);
    $usuario = trim($_POST['usuario']);
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);
    $nivel = trim($_POST['nivel']);

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    $sql = 'INSERT INTO user(nome, usuario, email, senha, nivel) values(?, ?, ?, ?, ?)';

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, 'sssss', $nome, $usuario, $email, $senhaHash, $nivel);

    if (mysqli_stmt_execute($stmt)) {
        header('Location: novoUser.php?message=sucess');
        exit;

    } else {
        header('Location: novoUser.php?message=error');
        exit;
    }


} else {
    header('Location: index.php');
    exit;
}