<?php
include 'verificaLogin.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: listarUsuarios.php');
    exit;
}

// Receber dados do formulário
$id    = (int)$_POST['id'];
$nome  = trim($_POST['nome']);
$email = trim($_POST['email']);
$senha = trim($_POST['senha']);
$nivel = trim($_POST['nivel']);
$status = trim($_POST['status']);
$preco = trim($_POST['preco']);

// Ler JSON
$arquivo = file_get_contents('login.JSON');
$usuarios = json_decode($arquivo, true);

// Atualizar usuário
foreach ($usuarios as &$user) {
    if ((int)$user['ID'] === $id) {
        $user['Nome']  = $nome;
        $user['Email'] = $email;
        $user['Senha'] = $senha; // futuramente hash
        $user['Nivel'] = $nivel;
        $user['Status'] = $status;
        $user['Preco'] = $preco;
        break;
    }
}

// Salvar de volta
file_put_contents('login.JSON', json_encode($usuarios, JSON_PRETTY_PRINT));

header('Location: usuarios.php');
exit;