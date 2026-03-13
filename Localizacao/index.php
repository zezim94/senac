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

        .btn-search {
            background: var(--dark);
            color: white;
        }

        .btn-gps {
            background: var(--primary);
            color: white;
        }

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
        }

        .info-card i {
            font-size: 1.5rem;
            color: var(--primary);
            margin-bottom: 10px;
        }

        .info-card span {
            display: block;
            font-size: 1.2rem;
            font-weight: bold;
        }

        .info-card label {
            font-size: 0.8rem;
            color: #7f8c8d;
            text-transform: uppercase;
        }
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
            <button class="btn btn-search" onclick="buscarEndereco()"><i class="fas fa-search"></i></button>
            <button class="btn btn-gps" onclick="usarGPS()" title="Usar minha localização"><i
                    class="fas fa-location-arrow"></i></button>
        </div>

        <div id="map"></div>

        <div class="info-panel">
            <div class="info-card">
                <i class="fas fa-route"></i>
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

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="js/mapa.js"></script>
</body>

</html>