<?php

session_start();

$arquivo = file_get_contents('login.JSON');
$usuarios = json_decode($arquivo, true);

$email = $_POST['email'];
$senha = $_POST['senha'];

$usuarioLogado = false;
$usuarioEncontrado = [];

foreach ($usuarios as $user) {

    if ($user['Email'] == $email && $user['Senha'] == $senha) {
        $usuarioLogado = true;
        $usuarioEncontrado = $user;
        break;
    }
}

if ($usuarioLogado) {
    $_SESSION['logado'] = true;
    $_SESSION['nome'] = $usuarioEncontrado['Nome'];
    $_SESSION['id'] = $usuarioEncontrado['ID'];
    $_SESSION['nivel'] = $usuarioEncontrado['Nivel'];
    header('Location: home.php');
    exit;

} else {
    $_SESSION['logado'] = false;
    $_SESSION['erro'] = 'Usuario ou senha invalidos';
    header('Location: index.php');
    exit;

}
