<?php
include "../config/conexao.php";
// Opcional: Buscar contagens para exibir nos cards
// $total_caminhoes = $conn->query("SELECT id FROM caminhoes")->num_rows;
// $total_rotas = $conn->query("SELECT id FROM rotas")->num_rows;
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logística Pro | Painel Administrativo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
        :root {
            --primary: #2c3e50;
            --secondary: #34495e;
            --accent: #3498db;
            --bg: #f8f9fa;
            --text-main: #2c3e50;
            --white: #ffffff;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            display: flex;
            background-color: var(--bg);
            color: var(--text-main);
            min-height: 100vh;
        }

        /* Sidebar */
        #sidebar {
            width: 260px;
            background: var(--primary);
            color: white;
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar-header {
            padding: 30px 20px;
            text-align: center;
            background: #1a252f;
        }

        .sidebar-header h2 {
            margin: 0;
            font-size: 1.2rem;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .nav-links {
            padding: 20px 0;
            flex: 1;
        }

        .nav-links a {
            display: flex;
            align-items: center;
            padding: 15px 25px;
            color: #bdc3c7;
            text-decoration: none;
            transition: 0.3s;
            border-left: 4px solid transparent;
            margin-bottom: 5px;
        }

        .nav-links a:hover {
            background: #34495e;
            color: white;
            border-left-color: var(--accent);
        }

        .nav-links i {
            margin-right: 15px;
            width: 20px;
            font-size: 1.1rem;
        }

        /* Área de Conteúdo */
        main {
            flex: 1;
            padding: 40px;
        }

        .welcome-section {
            margin-bottom: 40px;
        }

        .welcome-section h1 {
            margin: 0;
            font-size: 2rem;
            color: var(--primary);
        }

        .welcome-section p {
            color: #7f8c8d;
            margin: 5px 0 0 0;
        }

        /* Grid de Atalhos */
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
        }

        .stat-card {
            background: var(--white);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            text-decoration: none;
            color: var(--text-main);
            transition: transform 0.3s, box-shadow 0.3s;
            border: 1px solid #eee;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .icon-box {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-right: 20px;
        }

        .bg-blue {
            background: #e3f2fd;
            color: #3498db;
        }

        .bg-green {
            background: #e8f5e9;
            color: #27ae60;
        }

        .bg-orange {
            background: #fff3e0;
            color: #f39c12;
        }

        .stat-info h3 {
            margin: 0;
            font-size: 1.1rem;
        }

        .stat-info p {
            margin: 5px 0 0 0;
            font-size: 0.85rem;
            color: #7f8c8d;
        }

        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }

            #sidebar {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <aside id="sidebar">
        <div class="sidebar-header">
            <h2><i class="fas fa-truck-moving"></i> LogPro Admin</h2>
        </div>
        <nav class="nav-links">
            <a href="index.php"><i class="fas fa-chart-line"></i> Dashboard</a>
            <a href="caminhoes.php"><i class="fas fa-truck"></i> Caminhões</a>
            <a href="rotas.php"><i class="fas fa-route"></i> Gestão de Rotas</a>
            <a href="monitoramento.php"><i class="fas fa-satellite-dish"></i> Monitoramento</a>
        </nav>
    </aside>

    <main>
        <section class="welcome-section">
            <h1>Painel Administrativo</h1>
            <p>Seja bem-vindo. Selecione um módulo abaixo para gerenciar sua frota.</p>
        </section>

        <div class="dashboard-grid">
            <a href="caminhoes.php" class="stat-card">
                <div class="icon-box bg-blue">
                    <i class="fas fa-truck"></i>
                </div>
                <div class="stat-info">
                    <h3>Caminhões</h3>
                    <p>Cadastre e gerencie os veículos da frota.</p>
                </div>
            </a>

            <a href="rotas.php" class="stat-card">
                <div class="icon-box bg-green">
                    <i class="fas fa-map-marked-alt"></i>
                </div>
                <div class="stat-info">
                    <h3>Rotas</h3>
                    <p>Planeje itinerários e paradas de entrega.</p>
                </div>
            </a>

            <a href="monitoramento.php" class="stat-card">
                <div class="icon-box bg-orange">
                    <i class="fas fa-location-arrow"></i>
                </div>
                <div class="stat-info">
                    <h3>Monitoramento</h3>
                    <p>Acompanhe veículos em tempo real.</p>
                </div>
            </a>
        </div>
    </main>

</body>

</html>