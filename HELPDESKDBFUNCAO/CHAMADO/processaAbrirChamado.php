<?php
require_once '../verificaLogin.php';
require_once '../conexao.php';

$conn = conexao();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $titulo = $_POST['titulo'];
    $categoria = $_POST['categoria'];
    $descricao = $_POST['descricao'];
    $idUser = $_SESSION['id'];

    $sql = 'INSERT INTO chamados(titulo, categoria, descricao, userId) values(:titulo, :categoria, :descricao, :userId)';

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        'titulo' => $titulo,
        'categoria' => $categoria,
        'descricao' => $descricao,
        'userId' => $idUser
    ]);

 

    if ($stmt) {
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
