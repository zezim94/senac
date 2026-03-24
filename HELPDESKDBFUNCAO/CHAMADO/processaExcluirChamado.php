<?php
require_once '../verificaLogin.php';
require_once '../conexao.php';
require_once '../FUNCAO/funcaoChamado.php';

$conn = conexao();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = (int) $_POST['id'];

    $deleteChamado = delete($conn, $id);

    if (($deleteChamado)) {
        header('Location: consultar_chamado.php?message1=success1');
    } else {
        header('Location: consultar_chamado.php?message1=error1');

    }

} else {
    header('Location: consultar_chamado.php');
    exit;
}