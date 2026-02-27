<?php
require_once 'verificaLogin.php';
require_once 'conexao.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $titulo = $_POST['titulo'];
    $categoria = $_POST['categoria'];
    $descricao = $_POST['descricao'];
    $idUser = $_SESSION['id'];

    $sql = 'INSERT INTO chamados(titulo, categoria, descricao, userId) values(?, ?, ?, ?)';

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, 'sssi', $titulo, $categoria, $descricao, $idUser);

    if (mysqli_stmt_execute($stmt)) {
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
