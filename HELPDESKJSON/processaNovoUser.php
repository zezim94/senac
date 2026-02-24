<?php
include 'verificaLogin.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);
    $nivel = trim($_POST['nivel']);

    $arquivo = file_get_contents('login.JSON');
    $usuarios = json_decode($arquivo, true);

    if(!empty($usuarios)){
        $ultimoUser = end($usuarios);
        $novoId = $ultimoUser['ID'] + 1;
    } else{
        $novoId = 1;
    }

    $novoUsuario = [
        "ID" => $novoId,
        "Nome" => $nome,
        "Email" => $email,
        "Senha" => $senha,
        "Nivel" => $nivel
    ];

    $usuarios[] = $novoUsuario;

    file_put_contents('login.JSON', json_encode($usuarios, JSON_PRETTY_PRINT));

    header('Location: home.php');
    exit;

} else {
    header('Location: index.php');
    exit;
}