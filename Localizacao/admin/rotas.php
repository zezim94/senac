<?php
include "../config/conexao.php";
$rotas = $conn->query("SELECT * FROM rotas ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Gestão de Rotas</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
        :root {
            --bg: #f4f7f6;
            --primary: #2c3e50;
            --accent: #3498db;
            --white: #ffffff;
            --text-dark: #333;
            --text-light: #7f8c8d;
        }

        body {
            background-color: var(--bg);
            font-family: 'Segoe UI', system-ui, sans-serif;
            margin: 0;
            padding: 40px 20px;
            color: var(--text-dark);
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        h2 {
            margin: 0;
            font-size: 24px;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-nova {
            background-color: var(--accent);
            color: white;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 6px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(52, 152, 219, 0.2);
        }

        .btn-nova:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }

        /* Grid de Cards */
        .grid-rotas {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }

        .card {
            background: var(--white);
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s, box-shadow 0.2s;
            position: relative;
            border: 1px solid #eee;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .card-info h3 {
            margin: 0 0 10px 0;
            font-size: 18px;
            color: var(--primary);
        }

        .card-info p {
            margin: 5px 0;
            color: var(--text-light);
            font-size: 14px;
        }

        .card-footer {
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid #f0f0f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .badge-id {
            background: #ebf5fb;
            color: var(--accent);
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }

        .btn-abrir {
            background: var(--primary);
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 13px;
            transition: 0.2s;
        }

        .btn-abrir:hover {
            background: #1a252f;
        }

        .no-data {
            grid-column: 1 / -1;
            text-align: center;
            padding: 50px;
            background: white;
            border-radius: 12px;
            color: var(--text-light);
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header-section">
            <h2><i class="fas fa-map-marked-alt"></i> Minhas Rotas</h2>
            <a href="nova_rota.php" class="btn-nova">
                <i class="fas fa-plus"></i> Nova Rota
            </a>
        </div>

        <div class="grid-rotas">
            <?php if ($rotas->num_rows > 0): ?>
                <?php while ($r = $rotas->fetch_assoc()): ?>
                    <div class="card">
                        <div class="card-info">
                            <h3><?= htmlspecialchars($r['nome_rota']) ?></h3>
                            <p><i class="far fa-calendar-alt"></i> Criada em: <?= date('d/m/Y') ?></p>
                        </div>

                        <div class="card-footer">
                            <span class="badge-id">ID: <?= $r['id'] ?></span>
                            <button class="btn-abrir" onclick="abrirRota(<?= $r['id'] ?>)">
                                Editar Rota <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="no-data">
                    <i class="fas fa-route fa-3x" style="margin-bottom:15px; display:block;"></i>
                    <p>Nenhuma rota encontrada. Comece criando uma nova!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function abrirRota(id) {
            window.location = "pontos_rota.php?rota=" + id;
        }
    </script>

</body>

</html>