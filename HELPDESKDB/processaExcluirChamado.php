<?php
require_once 'verificaLogin.php';
require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = (int) $_POST['id'];

    $sql = 'DELETE FROM chamados WHERE id = ?';

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt,'i', $id);

      if (mysqli_stmt_execute($stmt)) {
        header('Location: consultar_chamado.php?message1=success1');
    } else {
        header('Location: consultar_chamado.php?message1=error1');

    }

} else {
    header('Location: consultar_chamado.php');
    exit;
}