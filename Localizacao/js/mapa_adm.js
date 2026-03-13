// Inicia o mapa (Centralizado no Estado de SP por padrão)
var map = L.map("map").setView([-23.96, -46.33], 12);

L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
    attribution: "© OpenStreetMap",
}).addTo(map);

// Ícones personalizados
var iconeAtivo = L.icon({
    iconUrl: "https://cdn-icons-png.flaticon.com/512/1048/1048329.png", // Verde
    iconSize: [40, 40], iconAnchor: [20, 20]
});
var iconeManutencao = L.icon({
    iconUrl: "https://cdn-icons-png.flaticon.com/512/1048/1048314.png", // Vermelho
    iconSize: [40, 40], iconAnchor: [20, 20]
});
var iconeSemSinal = L.icon({
    iconUrl: "https://cdn-icons-png.flaticon.com/512/1048/1048315.png", // Amarelo/Cinza
    iconSize: [40, 40], iconAnchor: [20, 20]
});

var marcadoresFrota = {};
var primeiraCarga = true;

function buscarFrota() {
    fetch("../api/todos_caminhoes.php")
        .then(r => r.json())
        .then(data => {
            if (!data || data.erro) return;

            var listaHtml = "";
            var bounds = [];

            data.forEach(caminhao => {
                // ESCUDO: Se vier null do banco, impede o erro e pula pro próximo
                if (caminhao.lat === null || caminhao.lng === null || caminhao.lat === "") {
                    // Monta só a lista lateral informando que falta configuração
                    listaHtml += `
                        <div class="card-veiculo sem-sinal" style="opacity:0.5;">
                            <div class="v-nome"><i class="fas fa-exclamation-triangle"></i> ${caminhao.nome}</div>
                            <div class="v-info">Placa: ${caminhao.placa}</div>
                            <div class="v-status">Falta Base/GPS</div>
                        </div>
                    `;
                    return; // Sai deste caminhão e não desenha no mapa
                }

                var lat = parseFloat(caminhao.lat);
                var lng = parseFloat(caminhao.lng);

                // Define o visual na lista e no mapa
                var classeStatus = "sem-sinal";
                var textoStatus = "Estacionado na Base";
                var iconeUsar = iconeSemSinal;
                
                if (caminhao.status === "Manutenção") {
                    classeStatus = "manutencao";
                    textoStatus = "Em Manutenção";
                    iconeUsar = iconeManutencao;
                } else if (caminhao.tem_sinal) {
                    classeStatus = "ativo";
                    textoStatus = "Online (Em Rota)";
                    iconeUsar = iconeAtivo;
                }

                // Cria o Card na barra lateral
                listaHtml += `
                    <div class="card-veiculo ${classeStatus}" onclick="focarCaminhao(${caminhao.id})">
                        <div class="v-nome"><i class="fas fa-truck"></i> ${caminhao.nome}</div>
                        <div class="v-info">Placa: ${caminhao.placa} | Mot: ${caminhao.motorista}</div>
                        <div class="v-status">${textoStatus}</div>
                    </div>
                `;

                // Desenha no mapa apenas se for um número válido
                if (!isNaN(lat) && !isNaN(lng)) {
                    var pos = [lat, lng];
                    bounds.push(pos);

                    var conteudoPopup = `
                        <div class="popup-custom">
                            <h4>${caminhao.nome}</h4>
                            <p><b>Motorista:</b> ${caminhao.motorista}</p>
                            <p><b>Placa:</b> ${caminhao.placa}</p>
                            <p><b>Status:</b> ${textoStatus}</p>
                        </div>
                    `;

                    // Se o pino já existe, apenas move ele. Se não, cria um novo.
                    if (marcadoresFrota[caminhao.id]) {
                        marcadoresFrota[caminhao.id].setLatLng(pos);
                        marcadoresFrota[caminhao.id].setIcon(iconeUsar);
                        marcadoresFrota[caminhao.id].getPopup().setContent(conteudoPopup);
                    } else {
                        var marker = L.marker(pos, { icon: iconeUsar }).bindPopup(conteudoPopup);
                        marker.addTo(map);
                        marcadoresFrota[caminhao.id] = marker;
                    }
                }
            });

            // Atualiza a barra
            document.getElementById("lista-veiculos").innerHTML = listaHtml;

            // Foca a câmera para mostrar todos
            if (primeiraCarga && bounds.length > 0) {
                map.fitBounds(bounds, { padding: [50, 50] });
                primeiraCarga = false;
            }
        })
        .catch(e => console.error("Falha ao atualizar frota:", e));
}

function focarCaminhao(id) {
    if (marcadoresFrota[id]) {
        map.setView(marcadoresFrota[id].getLatLng(), 16);
        marcadoresFrota[id].openPopup();
    } else {
        alert("Este veículo ainda não possui coordenadas registradas.");
    }
}

// Inicia o sistema
buscarFrota();
setInterval(buscarFrota, 5000);