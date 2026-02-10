<?php
session_start();
if (!isset($_SESSION['usuarios']) || !is_array($_SESSION['usuarios'])) {
    $_SESSION['usuarios'] = [];
}


function cadastro($dados)
{
    $_SESSION['usuarios'][] = [

        'usuario' => $dados['usuario'],
        'email' => $dados['email'],
        'senha' => password_hash($dados['senha'], PASSWORD_DEFAULT),
        'nivel' => $dados['nivel']
    ];

    $_SESSION['msg'] = 'Cadastro realizado com sucesso!';
    header('Location: index.php');
    exit;

}

function login($dados)
{
    $usuario = $dados['usuario'];
    $senha = $dados['senha'];

    foreach ($_SESSION['usuarios'] as $user) {

        if ($user['usuario'] === $usuario && password_verify($senha, $user['senha'])) {
            $_SESSION['logado'] = true;
            $_SESSION['usuario_nome'] = $usuario;
            $_SESSION['usuario_nivel'] = $user['nivel'];

            if ($user['nivel'] == 1) {
                header('Location: admin.php');
            } else {
                header('Location: user.php');
            }
            exit;
        }
    }

    $_SESSION['erro'] = 'Usuário ou senha inválidos!';
    header('Location: index.php');
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';

    if ($acao === 'cadastrar') {
        cadastro($_POST);
    } elseif ($acao === 'login') {
        login($_POST);
    } else {
        header('Location: index.php');
        exit;
    }
}