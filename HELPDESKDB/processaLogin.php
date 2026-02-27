<?php
session_start();
require_once("conexao.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = 'SELECT * FROM user WHERE email = ? OR usuario = ?';
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ss', $email, $email);
    mysqli_stmt_execute($stmt);

    $resul = mysqli_stmt_get_result($stmt);


    if ($resul && mysqli_num_rows($resul) === 1) {

        $user = mysqli_fetch_assoc($resul);

        if (password_verify($senha, $user['senha'])) {

            session_regenerate_id(true);

            $_SESSION['logado'] = true;
            $_SESSION['nome'] = $user['nome'];
            $_SESSION['id'] = $user['id'];
            $_SESSION['nivel'] = $user['nivel'];

            header("Location: home.php");
            exit;
        }

    }

    header('Location: index.php?login=erro');
    exit;

} else {
    $_SESSION['logado'] = false;
    header('Location: index.php');
    exit;
}
