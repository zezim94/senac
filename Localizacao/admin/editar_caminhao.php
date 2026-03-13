<?php
include "../config/conexao.php";

// Pega o ID da URL e protege contra injeção de SQL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$sql = "SELECT * FROM caminhoes WHERE id = $id";
$resultado = $conn->query($sql);

if ($resultado->num_rows == 0) {
    die("Caminhão não encontrado. <a href='caminhoes.php'>Voltar</a>");
}

$caminhao = $resultado->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Caminhão</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f4f7f6; padding: 40px; color: #333; }
        .form-container {
            max-width: 800px; background: white; padding: 30px; border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); margin: auto;
            display: grid; grid-template-columns: 1fr 1fr; gap: 20px;
        }
        .full-width { grid-column: 1 / -1; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #2c3e50; }
        input[type="text"], select { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        
        #mapa-regiao { height: 300px; width: 100%; border-radius: 8px; border: 2px solid #bdc3c7; margin-bottom: 10px; z-index: 1; }
        
        .range-container { display: flex; align-items: center; gap: 15px; }
        input[type="range"] { flex: 1; }
        
        .botoes-flex { display: flex; gap: 15px; margin-top: 15px; }
        .btn { padding: 12px; border-radius: 4px; font-weight: bold; font-size: 16px; cursor: pointer; text-align: center; border: none; flex: 1; text-decoration: none; transition: 0.3s; }
        .btn-salvar { background: #f39c12; color: white; }
        .btn-salvar:hover { background: #e67e22; }
        .btn-voltar { background: #95a5a6; color: white; }
        .btn-voltar:hover { background: #7f8c8d; }
    </style>
</head>
<body>

    <div class="form-container">
        <h2 class="full-width" style="text-align: center; color: #2c3e50; margin-top: 0;">
            <i class="fas fa-pen"></i> Editando Veículo #<?= $caminhao['id'] ?>
        </h2>
        
        <form action="atualizar_caminhao.php" method="POST" class="full-width" style="display: contents;">
            
            <input type="hidden" name="id" value="<?= $caminhao['id'] ?>">

            <div>
                <div class="form-group">
                    <label>Nome do Veículo (Frota):</label>
                    <input type="text" name="nome" value="<?= htmlspecialchars($caminhao['nome']) ?>" required>
                </div>
                <div class="form-group">
                    <label>Placa:</label>
                    <input type="text" name="placa" value="<?= htmlspecialchars($caminhao['placa']) ?>" required>
                </div>
                <div class="form-group">
                    <label>Motorista:</label>
                    <input type="text" name="motorista" value="<?= htmlspecialchars($caminhao['motorista']) ?>" required>
                </div>
                <div class="form-group">
                    <label>Status:</label>
                    <select name="status" required>
                        <option value="Ativo" <?= $caminhao['status'] == 'Ativo' ? 'selected' : '' ?>>🟢 Ativo (Em Rota)</option>
                        <option value="Manutenção" <?= $caminhao['status'] == 'Manutenção' ? 'selected' : '' ?>>🔴 Em Manutenção</option>
                    </select>
                </div>
            </div>

            <div>
                <label>📍 Clique e arraste ou clique em outro lugar para alterar a base:</label>
                <div id="mapa-regiao"></div>
                
                <div class="form-group">
                    <label>Raio de Atendimento: <span id="valor-raio"><?= $caminhao['raio_atendimento'] ?></span> km</label>
                    <div class="range-container">
                        <input type="range" id="input-raio" name="raio_atendimento" min="1" max="50" value="<?= $caminhao['raio_atendimento'] ?>">
                    </div>
                </div>

                <input type="hidden" name="lat_base" id="lat_base" value="<?= $caminhao['lat_base'] ?>">
                <input type="hidden" name="lng_base" id="lng_base" value="<?= $caminhao['lng_base'] ?>">
            </div>

            <div class="full-width botoes-flex">
                <a href="caminhoes.php" class="btn btn-voltar"><i class="fas fa-arrow-left"></i> Cancelar</a>
                <button type="submit" class="btn btn-salvar"><i class="fas fa-save"></i> Atualizar Caminhão</button>
            </div>

        </form>
    </div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        // Pega as coordenadas que vieram do Banco de Dados
        var latAtual = parseFloat(document.getElementById('lat_base').value) || -23.8950;
        var lngAtual = parseFloat(document.getElementById('lng_base').value) || -46.4246;
        var raioAtual = parseInt(document.getElementById('input-raio').value) || 5;

        // Inicia o mapa já centralizado onde o caminhão atende
        var map = L.map('mapa-regiao').setView([latAtual, lngAtual], 12);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);

        var marcador = null;
        var circulo = null;
        var inputRaio = document.getElementById('input-raio');
        var textoRaio = document.getElementById('valor-raio');

        // Função que desenha o marcador arrastável e a área de cobertura
        function desenharCerca(lat, lng, raioKm) {
            if (marcador) map.removeLayer(marcador);
            if (circulo) map.removeLayer(circulo);

            marcador = L.marker([lat, lng], { draggable: true }).addTo(map);
            
            circulo = L.circle([lat, lng], {
                color: '#e67e22',
                fillColor: '#f39c12',
                fillOpacity: 0.2,
                radius: raioKm * 1000 
            }).addTo(map);

            // Atualiza os inputs invisíveis
            document.getElementById('lat_base').value = lat;
            document.getElementById('lng_base').value = lng;

            // Se o usuário arrastar o ícone do caminhão no mapa, o círculo acompanha!
            marcador.on('dragend', function(event) {
                var novaPosicao = event.target.getLatLng();
                desenharCerca(novaPosicao.lat, novaPosicao.lng, inputRaio.value);
            });
        }

        // Desenha a cerca inicial ao carregar a página
        desenharCerca(latAtual, lngAtual, raioAtual);

        // Se clicar no mapa em outro lugar, move a cerca para lá
        map.on('click', function(e) {
            desenharCerca(e.latlng.lat, e.latlng.lng, inputRaio.value);
        });

        // Evento de arrastar a barra de Raio
        inputRaio.addEventListener('input', function() {
            textoRaio.innerText = this.value;
            if (marcador) {
                var posicao = marcador.getLatLng();
                desenharCerca(posicao.lat, posicao.lng, this.value);
            }
        });
    </script>
</body>
</html>