<?php
include 'verificaLogin.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = (int) $_POST['id'];

    // Ler arquivo
    $arquivo = file_get_contents('arquivo.JSON');
    $chamados = json_decode($arquivo, true);

    // Criar novo array sem o chamado excluído
    $novosChamados = [];

    foreach ($chamados as $chamado) {
        if ((int)$chamado['id'] !== $id) {
            $novosChamados[] = $chamado;
        }
    }

    // Salvar novamente no JSON
    file_put_contents('arquivo.JSON', json_encode($novosChamados, JSON_PRETTY_PRINT));

    header('Location: consultar_chamado.php');
    exit;

} else {
    header('Location: consultar_chamado.php');
    exit;
}