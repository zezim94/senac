<?php
include 'verificaLogin.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $titulo = $_POST['titulo'];
    $categoria = $_POST['categoria'];
    $descricao = $_POST['descricao'];

    $nomeUser = $_SESSION['nome'];
    $idUser = $_SESSION['id'];
    $nivelUser = $_SESSION['nivel'];

    $arquivo = file_get_contents('arquivo.JSON');
    $chamados = json_decode($arquivo, true);

    $chamado = array(
        'id' => count($chamados) + 1,
        'nome' => $nomeUser,
        'equipamento' => $titulo,
        'categoria' => $categoria,
        'descricao' => $descricao,
        'status' => 'aberto',
        'preco' => ''
    );

    $chamados[] = $chamado;

    file_put_contents('arquivo.JSON', json_encode($chamados));

    header('Location: consultar_chamado.php');
    exit;

} else {
    header('Location: index.php');
    exit;
}
