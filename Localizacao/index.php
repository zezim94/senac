<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Coleta Inteligente | Rastreamento</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
        :root {
            --primary: #2ecc71;
            --dark: #2c3e50;
            --light: #ecf0f1;
            --danger: #e74c3c;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            background: var(--light);
            color: var(--dark);
        }

        .container {
            max-width: 900px;
            margin: 20px auto;
            padding: 0 15px;
        }

        header {
            text-align: center;
            margin-bottom: 20px;
        }

        /* Barra de Busca */
        .search-container {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
        }

        input[type="text"] {
            flex: 1;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 8px;
            outline: none;
            transition: 0.3s;
        }

        input[type="text"]:focus {
            border-color: var(--primary);
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-search { background: var(--dark); color: white; }
        .btn-search:hover { background: #1a252f; }

        .btn-gps { background: var(--primary); color: white; }
        .btn-gps:hover { background: #27ae60; }

        #map {
            height: 450px;
            width: 100%;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            z-index: 1;
        }

        /* Painel de Info */
        .info-panel {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-top: 20px;
        }

        .info-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border-bottom: 4px solid var(--primary);
            transition: 0.3s;
        }

        .info-card.alerta-perto {
            border-bottom: 4px solid var(--danger);
            background: #fff5f5;
        }

        .info-card i { font-size: 1.5rem; color: var(--primary); margin-bottom: 10px; }
        .info-card.alerta-perto i { color: var(--danger); animation: piscarIcone 1s infinite alternate;}

        @keyframes piscarIcone {
            from { transform: scale(1); opacity: 0.8; }
            to { transform: scale(1.2); opacity: 1; }
        }

        .info-card span { display: block; font-size: 1.2rem; font-weight: bold; }
        .info-card label { font-size: 0.8rem; color: #7f8c8d; text-transform: uppercase; }

        /* --- ESTILOS DO MODAL DE ALERTA --- */
        .modal-overlay {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.75);
            display: none; /* Escondido por padrão */
            justify-content: center;
            align-items: center;
            z-index: 9999;
            backdrop-filter: blur(5px); /* Efeito de desfoque no fundo */
        }

        .modal-content {
            background: white;
            padding: 40px 30px;
            border-radius: 15px;
            text-align: center;
            max-width: 400px;
            width: 90%;
            box-shadow: 0 10px 40px rgba(231, 76, 60, 0.3);
            animation: deslizarModal 0.4s ease-out;
            border-top: 6px solid var(--danger);
        }

        @keyframes deslizarModal {
            from { transform: translateY(-50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .modal-icone {
            font-size: 4rem;
            color: var(--danger);
            margin-bottom: 15px;
            animation: piscarIcone 0.5s infinite alternate;
        }

        .modal-content h3 { margin: 0 0 10px 0; color: var(--dark); font-size: 1.5rem; }
        .modal-content p { color: #555; font-size: 1.1rem; margin-bottom: 25px; line-height: 1.5; }
        
        .btn-entendi {
            background: var(--danger);
            color: white;
            font-size: 1.1rem;
            padding: 15px 30px;
            width: 100%;
            border-radius: 50px;
            text-transform: uppercase;
        }
        .btn-entendi:hover { background: #c0392b; transform: scale(1.02); }
    </style>
</head>

<body>

    <div class="container">
        <header>
            <h2><i class="fas fa-truck-pickup"></i> Coleta Inteligente</h2>
            <p>Acompanhe o caminhão de lixo em tempo real</p>
        </header>

        <div class="search-container">
            <input type="text" id="endereco" placeholder="Digite seu endereço (Rua, Número, Cidade)...">
            <button class="btn btn-search" onclick="buscarEndereco()"><i class="fas fa-search"></i> Buscar</button>
            <button class="btn btn-gps" onclick="usarGPS()" title="Usar minha localização"><i class="fas fa-location-arrow"></i> Meu Local</button>
        </div>

        <div id="map"></div>

        <div class="info-panel">
            <div class="info-card" id="card-distancia">
                <i class="fas fa-route" id="icone-distancia"></i>
                <label>Distância</label>
                <span id="txt-distancia">-- km</span>
            </div>
            <div class="info-card">
                <i class="fas fa-stopwatch"></i>
                <label>Chegada Estimada</label>
                <span id="txt-tempo">-- min</span>
            </div>
        </div>
    </div>

    <div id="modal-alerta" class="modal-overlay">
        <div class="modal-content">
            <i class="fas fa-bell modal-icone"></i>
            <h3>O Caminhão Chegou!</h3>
            <p>Prepare o lixo! O caminhão de coleta está a menos de <strong>500 metros</strong> da sua localização.</p>
            <button class="btn btn-entendi" onclick="fecharAlertaModal()">OK, ENTENDI!</button>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        var map = L.map("map").setView([-23.96, -46.33], 13);

        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            attribution: "© OpenStreetMap",
        }).addTo(map);

        var usuarioMarker = null;
        var caminhaoMarker = null;
        var rotaLinha = null;
        var ultimaLatCaminhao = null;
        var ultimaLngCaminhao = null;

        var alertaTocado = false; 
        
        // --- CONFIGURAÇÃO DO ÁUDIO EM LOOP ---
        // Troquei por um som de sirene suave/aviso contínuo
        var somAlerta = new Audio("https://assets.mixkit.co/active_storage/sfx/2869/2869-preview.mp3");
        somAlerta.loop = true; // Faz o áudio tocar repetidamente

        var iconeCaminhao = L.icon({
            iconUrl: "https://cdn-icons-png.flaticon.com/512/1048/1048329.png",
            iconSize: [45, 45],
            iconAnchor: [22, 22],
        });

        // Libera a permissão de áudio no primeiro clique do usuário
        document.body.addEventListener('click', function() {
            somAlerta.load();
        }, { once: true });

        // --- FUNÇÕES DO MODAL ---
        function mostrarAlertaModal() {
            document.getElementById("modal-alerta").style.display = "flex";
            somAlerta.play().catch(e => console.log("Áudio bloqueado pelo navegador até o usuário interagir."));
        }

        function fecharAlertaModal() {
            document.getElementById("modal-alerta").style.display = "none";
            somAlerta.pause(); // Para o som
            somAlerta.currentTime = 0; // Reinicia o áudio para o início
        }
        // ------------------------

        function buscarEndereco() {
            var input = document.getElementById("endereco");
            if (!input) return;

            var query = input.value.trim();
            if (query.length < 5) {
                alert("Digite um endereço completo (Rua, Número, Cidade)");
                return;
            }

            var urlBusca = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`;

            fetch(urlBusca)
                .then((r) => r.json())
                .then((data) => {
                    if (data.length > 0) {
                        var ven = data[0];
                        definirLocalUsuario(parseFloat(ven.lat), parseFloat(ven.lon), ven.display_name);
                    } else {
                        alert("Endereço não encontrado.");
                    }
                })
                .catch((e) => console.error("Erro na busca:", e));
        }

        function usarGPS() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function (pos) {
                        definirLocalUsuario(pos.coords.latitude, pos.coords.longitude, "Sua localização atual");
                    },
                    function (erro) {
                        alert("Não foi possível acessar seu GPS.");
                    }
                );
            } else {
                alert("Seu navegador não suporta GPS.");
            }
        }

        function definirLocalUsuario(lat, lng, label) {
            if (usuarioMarker) map.removeLayer(usuarioMarker);

            usuarioMarker = L.marker([lat, lng])
                .addTo(map)
                .bindPopup(`📍 ${label}`)
                .openPopup();

            map.setView([lat, lng], 15);

            alertaTocado = false;
            ultimaLatCaminhao = null;
            atualizar();
        }

        function desenharRota(lat1, lng1, lat2, lng2) {
            var url = `https://router.project-osrm.org/route/v1/driving/${lng1},${lat1};${lng2},${lat2}?overview=full&geometries=geojson`;

            fetch(url)
                .then((res) => {
                    if (!res.ok) throw new Error("Rota impossível.");
                    return res.json();
                })
                .then((data) => {
                    if (!data || !data.routes || data.routes.length === 0) return;

                    var rota = data.routes[0];
                    var coords = rota.geometry.coordinates;
                    var distMetros = rota.distance; 

                    var txtDist = document.getElementById("txt-distancia");
                    var txtTempo = document.getElementById("txt-tempo");
                    var cardDist = document.getElementById("card-distancia");
                    var iconeDist = document.getElementById("icone-distancia");

                    if (txtDist) txtDist.innerText = (distMetros / 1000).toFixed(2) + " km";
                    if (txtTempo) txtTempo.innerText = Math.ceil(rota.duration / 60) + " min";

                    // --- ATIVA O MODAL SE ESTIVER A MENOS DE 500M ---
                    if (distMetros <= 500) {
                        cardDist.classList.add("alerta-perto");
                        iconeDist.classList.replace("fa-route", "fa-exclamation-triangle");

                        if (!alertaTocado) {
                            mostrarAlertaModal(); // Chama o Modal que fizemos!
                            alertaTocado = true;
                        }
                    } else {
                        cardDist.classList.remove("alerta-perto");
                        iconeDist.classList.replace("fa-exclamation-triangle", "fa-route");
                        alertaTocado = false; // Armou a "ratoeira" de novo se ele afastar e voltar
                    }

                    var pontos = coords.map((c) => [c[1], c[0]]);

                    if (rotaLinha) map.removeLayer(rotaLinha);

                    rotaLinha = L.polyline(pontos, {
                        color: "#2ecc71",
                        weight: 6,
                        opacity: 0.8,
                        lineJoin: "round",
                    }).addTo(map);
                })
                .catch((erro) => console.warn("Rota indisponível."));
        }

        function atualizar() {
            var url = "api/posicao_caminhao.php";

            if (usuarioMarker) {
                var user = usuarioMarker.getLatLng();
                url += `?lat=${user.lat}&lng=${user.lng}`;
            }

            fetch(url)
                .then((r) => r.json())
                .then((data) => {
                    if (data.encontrado === false) {
                        if (caminhaoMarker) { map.removeLayer(caminhaoMarker); caminhaoMarker = null; }
                        if (rotaLinha) { map.removeLayer(rotaLinha); rotaLinha = null; }

                        var txtDist = document.getElementById("txt-distancia");
                        var txtTempo = document.getElementById("txt-tempo");
                        if (txtDist) txtDist.innerText = "Fora de área";
                        if (txtTempo) txtTempo.innerText = "--";

                        ultimaLatCaminhao = null;
                        return;
                    }

                    var lat = parseFloat(data.latitude);
                    var lng = parseFloat(data.longitude);

                    if (caminhaoMarker == null) {
                        caminhaoMarker = L.marker([lat, lng], { icon: iconeCaminhao })
                            .addTo(map)
                            .bindPopup(`🚛 ${data.veiculo || "Caminhão de coleta"}`);
                    } else {
                        caminhaoMarker.setLatLng([lat, lng]);
                        if (data.veiculo) caminhaoMarker.getPopup().setContent(`🚛 ${data.veiculo}`);
                    }

                    if (usuarioMarker) {
                        if (lat !== ultimaLatCaminhao || lng !== ultimaLngCaminhao) {
                            var user = usuarioMarker.getLatLng();
                            desenharRota(lat, lng, user.lat, user.lng);

                            ultimaLatCaminhao = lat;
                            ultimaLngCaminhao = lng;
                        }
                    }
                })
                .catch((e) => console.error("Erro ao buscar caminhão:", e));
        }

        usarGPS();
        setInterval(atualizar, 5000);
    </script>
</body>
</html>