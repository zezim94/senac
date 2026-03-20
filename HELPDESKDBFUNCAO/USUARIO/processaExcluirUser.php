<?php
require_once '../verificaLogin.php';
require_once '../FUNCAO/funcaoUsuario.php';
require_once '../conexao.php';

$conn = conexao();


if (!isset($_GET['id'])) {
    header('Location: listarUsuarios.php'); // volta se não veio ID
    exit;
}

$idExcluir = (int) $_GET['id'];

deletarUsuario($conn, $idExcluir);

header("Location: usuarios.php");
