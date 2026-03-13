<?php

include "../config/conexao.php";

$data=json_decode(file_get_contents("php://input"),true);

$rota=$data['rota'];
$pontos=$data['pontos'];

$ordem=1;

foreach($pontos as $p){

$lat=$p[0];
$lng=$p[1];

$sql="INSERT INTO rota_pontos
(rota_id,latitude,longitude,ordem)
VALUES
('$rota','$lat','$lng','$ordem')";

$conn->query($sql);

$ordem++;

}

echo "ok";