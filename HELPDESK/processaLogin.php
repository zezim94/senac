<?php

session_start();

$usuarios = file('login.txt');

$email = $_POST['email'];
$senha = $_POST['senha'];

$usuarioLogado = false;
$usuarioEncontrado = [];

foreach ($usuarios as $user) {

    $dados = explode(';', trim($user));

    if ($dados[3] == $email && $dados[4] == $senha) {
        $usuarioLogado = true;
        $usuarioEncontrado = $dados;
        break;
    }
}

if ($usuarioLogado) {
    $_SESSION['logado'] = true;
    $_SESSION['nome'] = $usuarioEncontrado[1];
    $_SESSION['id'] = $usuarioEncontrado[0];
    $_SESSION['nivel'] = $usuarioEncontrado[2];
    header('Location: home.php');
    exit;

} else {
    $_SESSION['logado'] = false;
    $_SESSION['erro'] = 'Usuario ou senha invalidos';
    header('Location: index.php');
    exit;

}
