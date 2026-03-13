<?php
// 1. Avisa ao navegador que a resposta é um JSON
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

try {
    $conn = new mysqli("localhost", "root", "", "localizacao");
    if ($conn->connect_error) throw new Exception("Erro de conexão");

    // 2. Recebe a localização do usuário (enviada pelo mapa.js)
    $user_lat = isset($_GET['lat']) ? (float)$_GET['lat'] : null;
    $user_lng = isset($_GET['lng']) ? (float)$_GET['lng'] : null;

    // 3. Se o usuário já informou onde está (GPS ou Busca), faz o filtro da Cerca Virtual
    if ($user_lat && $user_lng) {
        
        // FÓRMULA DE HAVERSINE AVANÇADA
        // Busca o caminhão ativo que cobre a área e já puxa o último GPS dele na mesma query.
        // O "ORDER BY" garante que se duas áreas se cruzarem, ele pega o caminhão cuja BASE é mais próxima do morador.
        $sql = "
            SELECT 
                c.id, c.nome, c.lat_base, c.lng_base,
                (SELECT latitude FROM gps_caminhao WHERE caminhao_id = c.id ORDER BY id DESC LIMIT 1) AS gps_lat,
                (SELECT longitude FROM gps_caminhao WHERE caminhao_id = c.id ORDER BY id DESC LIMIT 1) AS gps_lng
            FROM caminhoes c
            WHERE c.status = 'Ativo' 
            AND (6371 * acos(
                cos(radians($user_lat)) * cos(radians(c.lat_base)) * cos(radians(c.lng_base) - radians($user_lng)) + 
                sin(radians($user_lat)) * sin(radians(c.lat_base))
            )) <= c.raio_atendimento
            ORDER BY (6371 * acos(
                cos(radians($user_lat)) * cos(radians(c.lat_base)) * cos(radians(c.lng_base) - radians($user_lng)) + 
                sin(radians($user_lat)) * sin(radians(c.lat_base))
            )) ASC
            LIMIT 1
        ";
        
        $res = $conn->query($sql);

        if ($res && $res->num_rows > 0) {
            $caminhao = $res->fetch_assoc();

            // MÁGICA: Tem GPS em tempo real? Usa. Não tem? Mostra ele estacionado na Base!
            $lat_final = !empty($caminhao['gps_lat']) ? $caminhao['gps_lat'] : $caminhao['lat_base'];
            $lng_final = !empty($caminhao['gps_lng']) ? $caminhao['gps_lng'] : $caminhao['lng_base'];

            echo json_encode([
                "encontrado" => true,
                "veiculo" => $caminhao['nome'],
                "latitude" => (float) $lat_final,
                "longitude" => (float) $lng_final
            ]);
            exit;
        } else {
            // Usuário está fora da área de cobertura de todos os caminhões
            echo json_encode(["encontrado" => false, "mensagem" => "Fora de área."]);
            exit;
        }
    }

    // 4. FALLBACK: Se o usuário ainda não ativou o GPS (acabou de abrir a tela)
    // Mostra um caminhão qualquer para o mapa não ficar vazio
    $sql_fallback = "
        SELECT 
            c.nome, c.lat_base, c.lng_base,
            (SELECT latitude FROM gps_caminhao WHERE caminhao_id = c.id ORDER BY id DESC LIMIT 1) AS gps_lat,
            (SELECT longitude FROM gps_caminhao WHERE caminhao_id = c.id ORDER BY id DESC LIMIT 1) AS gps_lng
        FROM caminhoes c
        WHERE c.status = 'Ativo'
        LIMIT 1
    ";
    
    $res_fall = $conn->query($sql_fallback);
    
    if ($res_fall && $res_fall->num_rows > 0) {
        $caminhao = $res_fall->fetch_assoc();
        
        $lat_final = !empty($caminhao['gps_lat']) ? $caminhao['gps_lat'] : $caminhao['lat_base'];
        $lng_final = !empty($caminhao['gps_lng']) ? $caminhao['gps_lng'] : $caminhao['lng_base'];

        echo json_encode([
            "encontrado" => true,
            "veiculo" => $caminhao['nome'],
            "latitude" => (float) $lat_final,
            "longitude" => (float) $lng_final
        ]);
    } else {
        echo json_encode(["encontrado" => false]);
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["erro" => "Sistema indisponível"]);
}
?>