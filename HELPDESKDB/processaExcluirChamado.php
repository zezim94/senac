<?php
require_once 'verificaLogin.php';
require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = (int) $_POST['id'];

    $sql = 'DELETE FROM chamados WHERE id = ?';

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt,'i', $id);

      if (mysqli_stmt_execute($stmt)) {
        header('Location: consultar_chamado.php?message=success');
    } else {
        header('Location: consultar_chamado.php?message=error');

    }

} else {
    header('Location: consultar_chamado.php');
    exit;
}