<?php
include "../config/conexao.php";
$rota_id = $_GET['rota'] ?? 1;
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Logística | Editor de Rotas</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

    <style>
        :root {
            --primary: #2c3e50;
            --secondary: #34495e;
            --accent: #3498db;
            --success: #27ae60;
            --danger: #e74c3c;
            --text: #ecf0f1;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        #painel {
            width: 350px;
            background: var(--primary);
            color: var(--text);
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.3);
            z-index: 1000;
        }

        .header {
            padding: 20px;
            background: #1a252f;
            text-align: center;
        }

        .header h2 {
            margin: 0;
            font-size: 1.2rem;
            letter-spacing: 1px;
        }

        .stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            padding: 15px;
            background: var(--secondary);
        }

        .stat-card {
            background: rgba(0, 0, 0, 0.2);
            padding: 10px;
            border-radius: 8px;
            text-align: center;
        }

        .stat-card small {
            display: block;
            font-size: 0.7rem;
            color: #bdc3c7;
            text-transform: uppercase;
        }

        .stat-card span {
            font-weight: bold;
            font-size: 0.9rem;
        }

        .controles {
            padding: 15px;
            display: flex;
            gap: 10px;
        }

        .btn {
            flex: 1;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-save {
            background: var(--success);
            color: white;
        }

        .btn-clear {
            background: var(--danger);
            color: white;
        }

        .btn:hover {
            opacity: 0.8;
            transform: translateY(-1px);
        }

        #lista_paradas {
            flex: 1;
            overflow-y: auto;
            padding: 15px;
        }

        .parada-item {
            background: var(--secondary);
            margin-bottom: 8px;
            padding: 12px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-left: 4px solid var(--accent);
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateX(-10px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .parada-info {
            font-size: 0.85rem;
        }

        .btn-remove {
            background: none;
            border: none;
            color: #95a5a6;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-remove:hover {
            color: var(--danger);
        }

        #map {
            flex: 1;
        }

        /* Custom Popup */
        .leaflet-popup-content-wrapper {
            background: var(--primary);
            color: white;
        }

        .leaflet-popup-tip {
            background: var(--primary);
        }
    </style>
</head>

<body>

    <div id="painel">
        <div class="header">
            <h2><i class="fas fa-route"></i> EDITOR DE ROTA</h2>
        </div>

        <input type="hidden" id="rota_id" value="<?= $rota_id ?>">

        <div class="stats">
            <div class="stat-card">
                <small>Paradas</small>
                <span id="total_paradas">0</span>
            </div>
            <div class="stat-card">
                <small>Distância</small>
                <span id="distancia_total">0.00 km</span>
            </div>
            <div class="stat-card" style="grid-column: span 2;">
                <small>Tempo Estimado</small>
                <span id="tempo_total">0 min</span>
            </div>
        </div>

        <div class="controles">
            <button class="btn btn-save" onclick="salvarRota()">
                <i class="fas fa-save"></i> Salvar
            </button>
            <button class="btn btn-clear" onclick="limparRota()">
                <i class="fas fa-trash"></i> Limpar
            </button>
        </div>

        <div id="lista_paradas">
        </div>
    </div>

    <div id="map"></div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        let map = L.map('map').setView([-23.96, -46.33], 13);
        let pontos = []; // Array de objetos {lat, lng}
        let marcadores = [];
        let linha = null;

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Inicialização
        carregarRota();

        function carregarRota() {
            const rotaId = document.getElementById("rota_id").value;
            fetch(`buscar_rota.php?rota=${rotaId}`)
                .then(r => r.json())
                .then(data => {
                    if (data.length === 0) return;
                    data.forEach(p => adicionarPonto(parseFloat(p.latitude), parseFloat(p.longitude), false));
                    desenharLinha();
                });
        }

        map.on('click', function (e) {
            adicionarPonto(e.latlng.lat, e.latlng.lng);
            desenharLinha();
        });

        function adicionarPonto(lat, lng, atualizarLinha = true) {
            const index = pontos.length;
            const ponto = { lat, lng };
            pontos.push(ponto);

            const marker = L.marker([lat, lng], {
                draggable: true,
                title: `Parada ${index + 1}`
            }).addTo(map);

            // Evento ao arrastar o marcador
            marker.on('dragend', function (event) {
                const position = event.target.getLatLng();
                pontos[index] = { lat: position.lat, lng: position.lng };
                desenharLinha();
                atualizarLista();
            });

            marcadores.push(marker);
            atualizarLista();
        }

        function removerPonto(index) {
            map.removeLayer(marcadores[index]);
            marcadores.splice(index, 1);
            pontos.splice(index, 1);

            // Reindexar marcadores restantes para que o dragend funcione no índice certo
            // Para um sistema robusto de produção, o ideal é usar IDs únicos, 
            // mas para este editor, vamos apenas redesenhar para simplificar
            reorganizarPontos();
        }

        function reorganizarPontos() {
            // Limpa tudo e refaz para garantir integridade dos índices
            marcadores.forEach(m => map.removeLayer(m));
            const pontosAntigos = [...pontos];
            pontos = [];
            marcadores = [];
            pontosAntigos.forEach(p => adicionarPonto(p.lat, p.lng, false));
            desenharLinha();
        }

        function atualizarLista() {
            const lista = document.getElementById("lista_paradas");
            lista.innerHTML = "";

            pontos.forEach((p, i) => {
                const item = document.createElement("div");
                item.className = "parada-item";
                item.innerHTML = `
                    <div class="parada-info">
                        <strong>#${i + 1}</strong><br>
                        <small>${p.lat.toFixed(4)}, ${p.lng.toFixed(4)}</small>
                    </div>
                    <button class="btn-remove" onclick="removerPonto(${i})" title="Remover">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                lista.appendChild(item);
            });

            document.getElementById("total_paradas").innerText = pontos.length;
        }

        function desenharLinha() {
            if (pontos.length < 2) {
                if (linha) map.removeLayer(linha);
                document.getElementById("distancia_total").innerText = "0.00 km";
                document.getElementById("tempo_total").innerText = "0 min";
                return;
            }

            const coordenadas = pontos.map(p => `${p.lng},${p.lat}`).join(";");
            const url = `https://router.project-osrm.org/route/v1/driving/${coordenadas}?overview=full&geometries=geojson`;

            fetch(url)
                .then(r => r.json())
                .then(data => {
                    if (!data.routes || data.routes.length === 0) return;

                    const rota = data.routes[0];
                    document.getElementById("distancia_total").innerText = (rota.distance / 1000).toFixed(2) + " km";
                    document.getElementById("tempo_total").innerText = (rota.duration / 60).toFixed(0) + " min";

                    const latlngs = rota.geometry.coordinates.map(c => [c[1], c[0]]);

                    if (linha) map.removeLayer(linha);

                    linha = L.polyline(latlngs, {
                        color: '#3498db',
                        weight: 6,
                        opacity: 0.7,
                        lineJoin: 'round'
                    }).addTo(map);
                });
        }

        function limparRota() {
            if (!confirm("Deseja realmente limpar toda a rota?")) return;

            const rotaId = document.getElementById("rota_id").value;
            fetch("apagar_rota.php", {
                method: "POST",
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: "rota=" + rotaId
            }).then(() => {
                pontos = [];
                marcadores.forEach(m => map.removeLayer(m));
                marcadores = [];
                if (linha) map.removeLayer(linha);
                atualizarLista();
                desenharLinha();
            });
        }

        function salvarRota() {
            const rotaId = document.getElementById("rota_id").value;
            // O OSRM retorna [lat, lng], convertemos para o formato que seu PHP espera
            const pontosParaSalvar = pontos.map(p => [p.lat, p.lng]);

            fetch("salvar_pontos_rota.php", {
                method: "POST",
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    rota: rotaId,
                    pontos: pontosParaSalvar
                })
            })
                .then(r => r.text())
                .then(() => alert("✅ Rota sincronizada com sucesso!"));
        }
    </script>
</body>

</html>