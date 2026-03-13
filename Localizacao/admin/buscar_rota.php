<?php

include "../config/conexao.php";

$rota = $_GET['rota'];

$sql = $conn->query("
SELECT latitude, longitude
FROM rota_pontos
WHERE rota_id = '$rota'
ORDER BY ordem
");

$dados = [];

while ($r = $sql->fetch_assoc()) {
    $dados[] = $r;
}

header('Content-Type: application/json');

echo json_encode($dados);