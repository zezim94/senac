<?php
include "../config/conexao.php";

$nome      = $conn->real_escape_string($_POST['nome']);
$placa     = $conn->real_escape_string($_POST['placa']);
$motorista = $conn->real_escape_string($_POST['motorista']);
$status    = $conn->real_escape_string($_POST['status']);

// Recebe os novos campos do mapa
$lat_base         = (float) $_POST['lat_base'];
$lng_base         = (float) $_POST['lng_base'];
$raio_atendimento = (int) $_POST['raio_atendimento'];

$sql = "INSERT INTO caminhoes (nome, placa, motorista, status, lat_base, lng_base, raio_atendimento) 
        VALUES ('$nome', '$placa', '$motorista', '$status', '$lat_base', '$lng_base', '$raio_atendimento')";

$conn->query($sql);

header("Location: caminhoes.php");
exit;
?>