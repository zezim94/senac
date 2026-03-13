<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Centro de Controle | Monitoramento</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        body { margin: 0; font-family: 'Segoe UI', sans-serif; display: flex; height: 100vh; overflow: hidden; background: #ecf0f1; }
        
        /* Painel Lateral */
        #painel-frota {
            width: 350px;
            background: #2c3e50;
            color: white;
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 10px rgba(0,0,0,0.2);
            z-index: 1000;
        }

        .header { padding: 20px; background: #1a252f; text-align: center; }
        .header h2 { margin: 0; font-size: 1.2rem; }
        .header p { margin: 5px 0 0 0; font-size: 0.85rem; color: #bdc3c7; }

        .btn-voltar { display: block; background: #34495e; color: white; text-align: center; padding: 10px; text-decoration: none; font-weight: bold; transition: 0.3s; }
        .btn-voltar:hover { background: #3498db; }

        /* Lista de Veículos */
        #lista-veiculos { flex: 1; overflow-y: auto; padding: 15px; }
        
        .card-veiculo {
            background: #34495e;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            border-left: 4px solid #7f8c8d;
            cursor: pointer;
            transition: 0.2s;
        }
        .card-veiculo:hover { background: #3b536b; }
        
        .card-veiculo.ativo { border-left-color: #2ecc71; }
        .card-veiculo.manutencao { border-left-color: #e74c3c; opacity: 0.7; }
        .card-veiculo.sem-sinal { border-left-color: #f1c40f; }

        .v-nome { font-weight: bold; font-size: 1.1rem; margin-bottom: 5px; }
        .v-info { font-size: 0.85rem; color: #bdc3c7; margin-bottom: 3px; }
        .v-status { font-size: 0.8rem; font-weight: bold; margin-top: 8px; display: inline-block; padding: 3px 8px; border-radius: 4px; background: rgba(0,0,0,0.2); }

        /* Mapa */
        #map { flex: 1; height: 100vh; z-index: 1; }
        
        /* Popup Personalizado no Mapa */
        .popup-custom h4 { margin: 0 0 5px 0; color: #2c3e50; }
        .popup-custom p { margin: 0; font-size: 13px; color: #7f8c8d; }
    </style>
</head>
<body>

    <div id="painel-frota">
        <div class="header">
            <h2><i class="fas fa-satellite-dish"></i> CCO Logística</h2>
            <p>Monitoramento em Tempo Real</p>
        </div>
        <a href="index.php" class="btn-voltar"><i class="fas fa-arrow-left"></i> Voltar ao Painel</a>
        
        <div id="lista-veiculos">
            </div>
    </div>

    <div id="map"></div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="../js/mapa_adm.js"></script> </body>
</html>