<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

try {
    // Conexão
    $conn = new mysqli("localhost", "root", "", "localizacao");
    if ($conn->connect_error)
        throw new Exception("Erro de conexão");

    // Busca TODOS os caminhões (incluindo a base) e cruza com a ÚLTIMA posição GPS
    $sql = "
        SELECT 
            c.id, c.nome, c.placa, c.motorista, c.status, c.lat_base, c.lng_base,
            g.latitude AS gps_lat, g.longitude AS gps_lng
        FROM caminhoes c
        LEFT JOIN gps_caminhao g 
            ON g.id = (
                SELECT MAX(id) 
                FROM gps_caminhao 
                WHERE caminhao_id = c.id
            )
    ";

    $result = $conn->query($sql);
    $frota = [];

    if ($result) {
        while ($row = $result->fetch_assoc()) {

            // Lógica de Prevenção de Erro (Fallback):
            // Tem GPS? Usa o GPS. Se não tem, usa a coordenada de Base. 
            $lat_final = !empty($row['gps_lat']) ? $row['gps_lat'] : $row['lat_base'];
            $lng_final = !empty($row['gps_lng']) ? $row['gps_lng'] : $row['lng_base'];

            // Define se está usando o sinal em tempo real ou se está parado na base
            $tem_sinal = !empty($row['gps_lat']) ? true : false;

            $frota[] = [
                "id" => $row['id'],
                "nome" => $row['nome'],
                "placa" => $row['placa'],
                "motorista" => $row['motorista'],
                "status" => $row['status'],
                "lat" => $lat_final, // Envia as coordenadas resolvidas
                "lng" => $lng_final,
                "tem_sinal" => $tem_sinal
            ];
        }
    }

    echo json_encode($frota);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["erro" => "Sistema indisponível"]);
}
?>