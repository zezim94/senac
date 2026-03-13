<?php
include "../config/conexao.php";

$rota = $_POST['rota'];

$conn->query("DELETE FROM rota_pontos WHERE rota_id='$rota'");

echo "ok";