<?php
include '../verificaLogin.php';
require_once '../conexao.php';
require_once '../FUNCAO/funcaoChamado.php';

$conn = conexao();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = (int) $_POST['id'];
    $titulo = trim($_POST['titulo']);
    $categoria = trim($_POST['categoria']);
    $descricao = trim($_POST['descricao']);
    $observacao = trim($_POST['observacao']);
    $status = trim($_POST['status']);
    $preco = str_replace(',', '.', $_POST['preco']);
    $preco = (float) $preco;

    $chamados = update($conn, $titulo, $categoria, $descricao, $observacao, $status, $preco, $id);

    if ($chamados) {
        header('Location: consultar_chamado.php?message=success');
    } else {
        header('Location: consultar_chamado.php?message=error');

    }


} else {
    header('Location: consultar_chamado.php');
    exit;
}