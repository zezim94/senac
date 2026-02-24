<?php
include 'verificaLogin.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = (int)$_POST['id'];
    $nome = trim($_POST['nome']);
    $equipamento = trim($_POST['equipamento']);
    $categoria = trim($_POST['categoria']);
    $descricao = trim($_POST['descricao']);
    $status = trim($_POST['status']);
    $preco = trim($_POST['preco']);

    // Ler JSON
    $arquivo = file_get_contents('arquivo.JSON');
    $chamados = json_decode($arquivo, true);

    // Atualizar chamado
    foreach ($chamados as &$chamado) {
        if ((int)$chamado['id'] === $id) {
            $chamado['nome'] = $nome;
            $chamado['equipamento'] = $equipamento;
            $chamado['categoria'] = $categoria;
            $chamado['descricao'] = $descricao;
            $chamado['status'] = $status;
            $chamado['preco'] = $preco;
            break;
        }
    }

    // Salvar de volta
    file_put_contents('arquivo.JSON', json_encode($chamados, JSON_PRETTY_PRINT));

    header('Location: consultar_chamado.php'); // volta para a lista
    exit;
} else {
    header('Location: consultar_chamado.php');
    exit;
}