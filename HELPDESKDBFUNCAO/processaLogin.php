<?php
session_start();
require_once("conexao.php");
$conn = conexao();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = 'SELECT * FROM user WHERE email = :login OR usuario = :login';
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'login' => $email,
    ]);

    $resul = $stmt->fetch(PDO::FETCH_ASSOC);


    if ($resul) {

        if (password_verify($senha, $resul['senha'])) {

            session_regenerate_id(true);

            $_SESSION['logado'] = true;
            $_SESSION['nome'] = $resul['nome'];
            $_SESSION['usuario'] = $resul['usuario'];
            $_SESSION['id'] = $resul['id'];
            $_SESSION['nivel'] = $resul['nivel'];

            header("Location: USUARIO/home.php");
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
