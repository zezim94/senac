// Inicia o mapa (Centralizado no Estado de SP por padrão)
var map = L.map("map").setView([-23.96, -46.33], 13);

L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
  attribution: "© OpenStreetMap",
}).addTo(map);

var usuarioMarker = null;
var caminhaoMarker = null;
var rotaLinha = null;

// Variáveis para evitar recalcular a rota se o caminhão não saiu do lugar
var ultimaLatCaminhao = null;
var ultimaLngCaminhao = null;

// Ícone personalizado para o caminhão
var iconeCaminhao = L.icon({
  iconUrl: "https://cdn-icons-png.flaticon.com/512/1048/1048329.png",
  iconSize: [45, 45],
  iconAnchor: [22, 22],
});

// Função para buscar endereço (Geocoding)
function buscarEndereco() {
  var input = document.getElementById("endereco");
  if (!input) return; // Trava de segurança

  var query = input.value.trim();
  if (query.length < 5) {
    alert("Digite um endereço completo (Rua, Número, Cidade)");
    return;
  }

  // encodeURIComponent garante que espaços e acentos não quebrem a URL
  var urlBusca = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`;

  fetch(urlBusca)
    .then((r) => r.json())
    .then((data) => {
      if (data.length > 0) {
        var ven = data[0];
        definirLocalUsuario(
          parseFloat(ven.lat),
          parseFloat(ven.lon),
          ven.display_name,
        );
      } else {
        alert("Endereço não encontrado. Tente colocar a cidade junto.");
      }
    })
    .catch((e) => {
      console.error("Erro na busca de endereço:", e);
      alert("Erro ao buscar endereço. Tente novamente.");
    });
}

// Função para localização via navegador (GPS do Celular/PC)
function usarGPS() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
      function (pos) {
        definirLocalUsuario(
          pos.coords.latitude,
          pos.coords.longitude,
          "Sua localização atual",
        );
      },
      function (erro) {
        alert(
          "Não foi possível acessar seu GPS. Verifique se a permissão foi concedida ou digite o endereço manualmente.",
        );
      },
    );
  } else {
    alert("Seu navegador não suporta GPS.");
  }
}

// Marca o usuário no mapa e força a busca pelo caminhão
function definirLocalUsuario(lat, lng, label) {
  if (usuarioMarker) map.removeLayer(usuarioMarker);

  usuarioMarker = L.marker([lat, lng])
    .addTo(map)
    .bindPopup(`📍 ${label}`)
    .openPopup();

  map.setView([lat, lng], 15);

  // Reseta a última posição para forçar o desenho da rota
  ultimaLatCaminhao = null;
  atualizar();
}

// Desenhar rota e calcular distância/tempo
function desenharRota(lat1, lng1, lat2, lng2) {
  var url = `https://router.project-osrm.org/route/v1/driving/${lng1},${lat1};${lng2},${lat2}?overview=full&geometries=geojson`;

  fetch(url)
    .then((res) => {
      if (!res.ok) throw new Error("Rota impossível ou muito distante.");
      return res.json();
    })
    .then((data) => {
      if (!data || !data.routes || data.routes.length === 0) return;

      var rota = data.routes[0];
      var coords = rota.geometry.coordinates;

      // Atualiza Painel de Info com travas de segurança
      var txtDist = document.getElementById("txt-distancia");
      var txtTempo = document.getElementById("txt-tempo");

      if (txtDist)
        txtDist.innerText = (rota.distance / 1000).toFixed(2) + " km";
      if (txtTempo) txtTempo.innerText = Math.ceil(rota.duration / 60) + " min";

      var pontos = coords.map((c) => [c[1], c[0]]);

      if (rotaLinha) map.removeLayer(rotaLinha);

      rotaLinha = L.polyline(pontos, {
        color: "#2ecc71",
        weight: 6,
        opacity: 0.8,
        lineJoin: "round",
      }).addTo(map);
    })
    .catch((erro) => {
      console.warn("Aviso de Rota:", erro.message);
      var txtDist = document.getElementById("txt-distancia");
      var txtTempo = document.getElementById("txt-tempo");
      if (txtDist) txtDist.innerText = "Rota indisponível";
      if (txtTempo) txtTempo.innerText = "--";
    });
}

// ATUALIZAR CAMINHÃO
function atualizar() {
  var url = "api/posicao_caminhao.php";

  // Envia a localização do usuário para a API fazer o cálculo da Cerca Virtual
  if (usuarioMarker) {
    var user = usuarioMarker.getLatLng();
    url += `?lat=${user.lat}&lng=${user.lng}`;
  }

  fetch(url)
    .then((r) => r.json())
    .then((data) => {
      // Se não achou caminhão na Cerca Virtual do usuário
      if (data.encontrado === false) {
        if (caminhaoMarker) {
          map.removeLayer(caminhaoMarker);
          caminhaoMarker = null;
        }
        if (rotaLinha) {
          map.removeLayer(rotaLinha);
          rotaLinha = null;
        }

        var txtDist = document.getElementById("txt-distancia");
        var txtTempo = document.getElementById("txt-tempo");
        if (txtDist) txtDist.innerText = "Fora de área";
        if (txtTempo) txtTempo.innerText = "--";

        ultimaLatCaminhao = null; // Reseta cache
        return;
      }

      // Achou caminhão!
      var lat = parseFloat(data.latitude);
      var lng = parseFloat(data.longitude);

      // Atualiza ou cria o ícone do caminhão
      if (caminhaoMarker == null) {
        caminhaoMarker = L.marker([lat, lng], { icon: iconeCaminhao })
          .addTo(map)
          .bindPopup(`🚛 ${data.veiculo || "Caminhão de coleta"}`);
      } else {
        caminhaoMarker.setLatLng([lat, lng]);
        if (data.veiculo)
          caminhaoMarker.getPopup().setContent(`🚛 ${data.veiculo}`);
      }

      // Só recalcula a rota e consome a API se o caminhão REALMENTE andou
      if (usuarioMarker) {
        if (lat !== ultimaLatCaminhao || lng !== ultimaLngCaminhao) {
          var user = usuarioMarker.getLatLng();
          desenharRota(lat, lng, user.lat, user.lng);

          // Salva a posição para não recalcular à toa na próxima verificação
          ultimaLatCaminhao = lat;
          ultimaLngCaminhao = lng;
        }
      }
    })
    .catch((e) => console.error("Erro ao buscar caminhão:", e));
}

// Inicia tentando pegar o GPS do usuário
usarGPS();

// Intervalo de atualização (a cada 5 segundos)
setInterval(atualizar, 5000);
