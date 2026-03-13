<?php
include "../config/conexao.php";

// Verifica se os dados vieram via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Proteção básica
    $id               = (int) $_POST['id'];
    $nome             = $conn->real_escape_string($_POST['nome']);
    $placa            = $conn->real_escape_string($_POST['placa']);
    $motorista        = $conn->real_escape_string($_POST['motorista']);
    $status           = $conn->real_escape_string($_POST['status']);
    
    // Coordenadas da Cerca
    $lat_base         = (float) $_POST['lat_base'];
    $lng_base         = (float) $_POST['lng_base'];
    $raio_atendimento = (int) $_POST['raio_atendimento'];

    // Prepara a query de atualização (UPDATE)
    $sql = "UPDATE caminhoes SET 
                nome = '$nome', 
                placa = '$placa', 
                motorista = '$motorista', 
                status = '$status', 
                lat_base = '$lat_base', 
                lng_base = '$lng_base', 
                raio_atendimento = '$raio_atendimento' 
            WHERE id = $id";

    // Executa e redireciona
    if ($conn->query($sql) === TRUE) {
        header("Location: caminhoes.php?msg=sucesso");
        exit;
    } else {
        echo "Erro ao atualizar: " . $conn->error;
    }
} else {
    // Se tentarem acessar direto pela URL
    header("Location: caminhoes.php");
    exit;
}
?>