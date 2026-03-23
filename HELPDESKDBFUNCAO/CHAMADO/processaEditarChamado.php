<?php
include '../verificaLogin.php';
require_once '../conexao.php';

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

    $sql = 'UPDATE chamados set titulo = :titulo, categoria = :categoria, descricao = :descricao, statusTec = :statusTec, status = :status, preco = :preco WHERE id = :id';


    $stmt = $conn->prepare($sql);

    $stmt->execute([
        'titulo' => $titulo,
        'categoria' => $categoria,
        'descricao' => $descricao,
        'statusTec' => $observacao,
        'status' => $status,
        'preco' => $preco,
        'id' => $id
    ]);


    if ($stmt->rowCount() > 0) {
        header('Location: consultar_chamado.php?message=success');
    } else {
        header('Location: consultar_chamado.php?message=error');

    }


} else {
    header('Location: consultar_chamado.php');
    exit;
}