<?php
include 'verificaLogin.php';
require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = (int) $_POST['id'];
    $titulo = trim($_POST['titulo']);
    $categoria = trim($_POST['categoria']);
    $descricao = trim($_POST['descricao']);
    $status = trim($_POST['status']);
    $preco = str_replace(',', '.', $_POST['preco']);
    $preco = (float) $preco;

    $sql = 'UPDATE chamados set titulo = ?, categoria = ?, descricao = ?, status = ?, preco = ? WHERE id = ?';


    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, 'ssssdi', $titulo, $categoria, $descricao, $status, $preco, $id);

    if (mysqli_stmt_execute($stmt)) {
        header('Location: consultar_chamado.php?message=success');
    } else {
        header('Location: consultar_chamado.php?message=error');

    }


} else {
    header('Location: consultar_chamado.php');
    exit;
}