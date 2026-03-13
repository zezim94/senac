<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Caminhão</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f7f6;
            padding: 40px;
        }

        /* Container mais largo para caber o mapa confortavelmente */
        .form-container {
            max-width: 800px;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin: auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .full-width { grid-column: 1 / -1; }
        .form-group { margin-bottom: 15px; }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #2c3e50;
        }

        input, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        /* Estilo específico para o Mapa e Raio */
        #mapa-regiao {
            height: 300px;
            width: 100%;
            border-radius: 8px;
            border: 2px solid #bdc3c7;
            margin-bottom: 10px;
        }

        .range-container {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        input[type="range"] { flex: 1; }

        .btn {
            background: #27ae60;
            color: white;
            border: none;
            padding: 15px;
            width: 100%;
            border-radius: 4px;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn:hover { background: #2ecc71; }
    </style>
</head>
<body>

    <div class="form-container">
        <h2 class="full-width" style="text-align: center; color: #2c3e50; margin-top: 0;">🚚 Cadastrar Caminhão com Cerca Virtual</h2>
        
        <form action="salvar_caminhao.php" method="POST" class="full-width" style="display: contents;">
            
            <div>
                <div class="form-group">
                    <label>Nome do Veículo (Frota):</label>
                    <input type="text" name="nome" placeholder="Ex: Caminhão Compactador 01" required>
                </div>
                <div class="form-group">
                    <label>Placa:</label>
                    <input type="text" name="placa" placeholder="ABC-1234" required>
                </div>
                <div class="form-group">
                    <label>Motorista:</label>
                    <input type="text" name="motorista" placeholder="Nome do Motorista" required>
                </div>
                <div class="form-group">
                    <label>Status:</label>
                    <select name="status" required>
                        <option value="Ativo">🟢 Ativo (Em Rota)</option>
                        <option value="Manutenção">🔴 Em Manutenção</option>
                    </select>
                </div>
            </div>

            <div>
                <label>📍 Clique no mapa para definir a base:</label>
                <div id="mapa-regiao"></div>
                
                <div class="form-group">
                    <label>Raio de Atendimento: <span id="valor-raio">5</span> km</label>
                    <div class="range-container">
                        <input type="range" id="input-raio" name="raio_atendimento" min="1" max="50" value="5">
                    </div>
                </div>

                <input type="hidden" name="lat_base" id="lat_base" required>
                <input type="hidden" name="lng_base" id="lng_base" required>
            </div>

            <div class="full-width" style="margin-top: 10px;">
                <button type="submit" class="btn" onclick="return validarMapa()">💾 Salvar Caminhão</button>
            </div>

        </form>
    </div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        // Inicia o mapa (Centralizado no Estado de SP por padrão)
        var map = L.map('mapa-regiao').setView([-23.8950, -46.4246], 11);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);

        var marcador;
        var circulo;
        var inputRaio = document.getElementById('input-raio');
        var textoRaio = document.getElementById('valor-raio');

        // Função para desenhar no mapa
        function atualizarCerca(lat, lng, raioKm) {
            if (marcador) map.removeLayer(marcador);
            if (circulo) map.removeLayer(circulo);

            // Adiciona Ponto
            marcador = L.marker([lat, lng]).addTo(map);
            
            // Adiciona Círculo (Leaflet usa metros, então multiplica o km por 1000)
            circulo = L.circle([lat, lng], {
                color: '#3498db',
                fillColor: '#3498db',
                fillOpacity: 0.2,
                radius: raioKm * 1000 
            }).addTo(map);

            // Salva nos inputs escondidos para enviar via formulário
            document.getElementById('lat_base').value = lat;
            document.getElementById('lng_base').value = lng;
        }

        // Evento de clique no mapa
        map.on('click', function(e) {
            atualizarCerca(e.latlng.lat, e.latlng.lng, inputRaio.value);
        });

        // Evento de arrastar a barra de Raio
        inputRaio.addEventListener('input', function() {
            textoRaio.innerText = this.value;
            // Se já existir um marcador, atualiza o círculo em tempo real
            if (marcador) {
                var posicao = marcador.getLatLng();
                atualizarCerca(posicao.lat, posicao.lng, this.value);
            }
        });

        // Impede o envio se o administrador não clicou no mapa
        function validarMapa() {
            if(!document.getElementById('lat_base').value) {
                alert("Por favor, clique no mapa para definir a base de atuação do caminhão.");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>