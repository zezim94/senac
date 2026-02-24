<?php
include 'verificaLogin.php';

if (!isset($_GET['id'])) {
    header('Location: listarUsuarios.php'); // volta se não veio ID
    exit;
}

$idExcluir = (int) $_GET['id'];

// Ler JSON
$arquivo = file_get_contents('login.JSON');
$usuarios = json_decode($arquivo, true);

// Filtrar usuários, removendo o que tem o ID igual
$usuariosAtualizados = array_filter($usuarios, function ($user) use ($idExcluir) {
    return (int) $user['ID'] !== $idExcluir;
});

// Reindexar array para evitar gaps nos índices
$usuariosAtualizados = array_values($usuariosAtualizados);

// Salvar de volta no JSON
file_put_contents('login.JSON', json_encode($usuariosAtualizados, JSON_PRETTY_PRINT));

header('Location: usuarios.php');
exit;