<?php
include 'verificaLogin.php';

$id = (int)$_GET['id'];

$arquivo = file_get_contents('arquivo.JSON');
$chamados = json_decode($arquivo, true);

foreach ($chamados as $chamado) {
    if ((int)$chamado['id'] === $id) {
        echo json_encode($chamado);
        exit;
    }
}

echo json_encode(null);