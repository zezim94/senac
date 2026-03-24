<?php
require_once '../verificaLogin.php';
require_once '../conexao.php';
require_once '../FUNCAO/funcaoChamado.php';

$conn = conexao();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $titulo = $_POST['titulo'];
    $categoria = $_POST['categoria'];
    $descricao = $_POST['descricao'];
    $idUser = $_SESSION['id'];

    $criarChamado = criar($conn, $titulo, $categoria, $descricao, $idUser);

    if ($criarChamado) {
        header('Location: abrir_chamado.php?message=sucess');
        exit;
    } else {
        header('Location: abrir_chamado.php?message=error');
        exit;
    }

} else {
    header('Location: index.php');
    exit;
}
