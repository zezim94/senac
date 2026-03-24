<?php
include '../verificaLogin.php';
require_once '../conexao.php';


$conn = conexao();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nome = trim($_POST['nome']);
    $usuario = trim($_POST['usuario']);
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);
    $nivel = trim($_POST['nivel']);

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    $sql = 'INSERT INTO user(nome, usuario, email, senha, nivel) values(:nome, :usuario, :email, :senha, :nivel)';

    $stmt = $conn->prepare($sql);

    $resul = $stmt->execute([
        'nome' => $nome,
        'usuario' => $usuario,
        'email' => $email,
        'senha' => $senhaHash,
        'nivel' => $nivel
    ]);

    if ($resul) {
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