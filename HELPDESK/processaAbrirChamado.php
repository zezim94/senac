<?php
include 'verificaLogin.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $titulo = $_POST['titulo'];
    $categoria = $_POST['categoria'];
    $descricao = $_POST['descricao'];

    $nomeUser = $_SESSION['nome'];
    $idUser = $_SESSION['id'];
    $nivelUser = $_SESSION['nivel'];

    $arquivo = fopen('arquivo.txt', 'a');

    fwrite($arquivo, $idUser . ' - ' . $nomeUser . ' - ' . $nivelUser . ' - ' . $titulo . ' - ' . $categoria . ' - ' . $descricao . PHP_EOL);

    fclose($arquivo);

    header('Location: consultar_chamado.php');
    exit;

} else {
    header('Location: index.php');
    exit;
}
