<?php
include "../config/conexao.php";
$sql = $conn->query("SELECT * FROM caminhoes ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Gestão de Caminhões</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f4f7f6; padding: 40px; color: #333; }
        .container { max-width: 1000px; margin: auto; }
        .header-flex { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        
        .btn-novo { background: #2ecc71; color: white; text-decoration: none; padding: 10px 20px; border-radius: 5px; font-weight: bold; transition: 0.3s; }
        .btn-novo:hover { background: #27ae60; }

        table { width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05); }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #2c3e50; color: white; }
        tr:hover { background: #f9f9f9; }

        .badge-cobertura { background: #e8f8f5; color: #1abc9c; padding: 6px 12px; border-radius: 12px; font-size: 0.85em; font-weight: bold; }
        .status-ativo { color: #27ae60; font-weight: bold; }
        .status-inativo { color: #e74c3c; font-weight: bold; }
        .coordenadas { display: block; font-size: 0.75em; color: #7f8c8d; margin-top: 4px; }

        /* Botões de Ação */
        .acoes-flex { display: flex; gap: 8px; }
        .btn-acao { padding: 8px 12px; border: none; border-radius: 4px; cursor: pointer; color: white; text-decoration: none; font-size: 14px; transition: 0.2s; }
        .btn-ver { background: #3498db; }
        .btn-editar { background: #f39c12; }
        .btn-acao:hover { opacity: 0.8; }

        /* Estilos do Modal (Janela do Mapa) */
        .modal-overlay {
            display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.6); z-index: 1000; justify-content: center; align-items: center;
        }
        .modal-content {
            background: white; width: 600px; max-width: 90%; padding: 20px; border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3); position: relative;
        }
        .modal-header { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 15px; }
        .modal-header h3 { margin: 0; color: #2c3e50; }
        .btn-fechar { background: none; border: none; font-size: 20px; cursor: pointer; color: #e74c3c; }
        #map-modal { height: 350px; width: 100%; border-radius: 8px; z-index: 1; }
    </style>
</head>

<body>

    <div class="container">
        <div class="header-flex">
            <h2><i class="fas fa-truck"></i> Frota de Caminhões</h2>
            <a href="cadastrar_caminhao.php" class="btn-novo"><i class="fas fa-plus"></i> Novo Caminhão</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Veículo</th>
                    <th>Motorista</th>
                    <th>Área de Cobertura</th>
                    <th>Status</th>
                    <th>Ações</th> </tr>
            </thead>
            <tbody>
                <?php while ($c = $sql->fetch_assoc()): ?>
                    <tr>
                        <td>#<?= $c['id'] ?></td>
                        <td>
                            <strong><?= htmlspecialchars($c['nome']) ?></strong><br>
                            <small style="color: #7f8c8d;"><?= htmlspecialchars($c['placa']) ?></small>
                        </td>
                        <td><i class="fas fa-user-circle"></i> <?= htmlspecialchars($c['motorista']) ?></td>

                        <td>
                            <span class="badge-cobertura">
                                <i class="fas fa-crosshairs"></i> Raio: <?= htmlspecialchars($c['raio_atendimento']) ?> km
                            </span>
                            <span class="coordenadas">Lat: <?= $c['lat_base'] ?> | Lng: <?= $c['lng_base'] ?></span>
                        </td>

                        <td>
                            <?php if ($c['status'] == 'Ativo'): ?>
                                <span class="status-ativo"><i class="fas fa-check-circle"></i> Ativo</span>
                            <?php else: ?>
                                <span class="status-inativo"><i class="fas fa-wrench"></i> Manutenção</span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <div class="acoes-flex">
                                <button class="btn-acao btn-ver" title="Ver no Mapa" 
                                    onclick="abrirMapa(<?= $c['lat_base'] ?>, <?= $c['lng_base'] ?>, <?= $c['raio_atendimento'] ?>, '<?= htmlspecialchars($c['nome']) ?>')">
                                    <i class="fas fa-map-marked-alt"></i> Mapa
                                </button>
                                
                                <a href="editar_caminhao.php?id=<?= $c['id'] ?>" class="btn-acao btn-editar" title="Editar Caminhão">
                                    <i class="fas fa-pen"></i> Editar
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <div class="modal-overlay" id="modalMapa">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitulo"><i class="fas fa-satellite-dish"></i> Área de Cobertura</h3>
                <button class="btn-fechar" onclick="fecharModal()"><i class="fas fa-times"></i></button>
            </div>
            <div id="map-modal"></div>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        let mapaVisor = null;
        let camadaRaio = null;

        function abrirMapa(lat, lng, raioKm, nomeCaminhao) {
            // Mostra o Modal
            document.getElementById('modalMapa').style.display = 'flex';
            document.getElementById('modalTitulo').innerHTML = `<i class="fas fa-satellite-dish"></i> Cobertura: ${nomeCaminhao}`;

            // Se o mapa ainda não foi criado, inicializa ele
            if (!mapaVisor) {
                mapaVisor = L.map('map-modal').setView([lat, lng], 13);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap'
                }).addTo(mapaVisor);
                
                camadaRaio = L.layerGroup().addTo(mapaVisor);
            }

            // O Leaflet tem um bug ao abrir dentro de divs ocultas. Isso força ele a recalcular o tamanho correto:
            setTimeout(() => {
                mapaVisor.invalidateSize();
            }, 200);

            // Limpa marcações antigas
            camadaRaio.clearLayers();

            // Centraliza no caminhão selecionado
            mapaVisor.setView([lat, lng], 12);

            // Desenha o Ponto Base
            L.marker([lat, lng])
                .addTo(camadaRaio)
                .bindPopup(`<b>Base do Veículo:</b><br>${nomeCaminhao}`)
                .openPopup();

            // Desenha a Cerca Virtual (Raio)
            L.circle([lat, lng], {
                color: '#3498db',
                fillColor: '#3498db',
                fillOpacity: 0.2,
                radius: raioKm * 1000 // Leaflet usa metros, então multiplicamos por 1000
            }).addTo(camadaRaio);
        }

        function fecharModal() {
            document.getElementById('modalMapa').style.display = 'none';
        }

        // Fecha o modal ao clicar fora dele
        window.onclick = function(event) {
            let modal = document.getElementById('modalMapa');
            if (event.target == modal) {
                fecharModal();
            }
        }
    </script>
</body>
</html>