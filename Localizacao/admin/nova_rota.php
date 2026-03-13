<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Rota | Gestão de Logística</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: #333;
        }

        .form-container {
            background: #ffffff;
            width: 100%;
            max-width: 500px;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border-top: 5px solid #3498db;
        }

        .form-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .form-header h2 {
            margin: 0;
            color: #2c3e50;
            font-size: 1.5rem;
        }

        .form-header p {
            color: #7f8c8d;
            margin-top: 5px;
            font-size: 0.9rem;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2c3e50;
        }

        .form-group input[type="text"],
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #dcdde1;
            border-radius: 6px;
            box-sizing: border-box;
            font-family: inherit;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .form-group input[type="text"]:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.2);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .botoes-container {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .btn {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            font-size: 1rem;
            cursor: pointer;
            transition: 0.3s;
            text-align: center;
            text-decoration: none;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
        }

        .btn-salvar {
            background-color: #2ecc71;
            color: white;
        }

        .btn-salvar:hover {
            background-color: #27ae60;
        }

        .btn-voltar {
            background-color: #ecf0f1;
            color: #7f8c8d;
        }

        .btn-voltar:hover {
            background-color: #bdc3c7;
            color: #2c3e50;
        }
    </style>
</head>

<body>

    <div class="form-container">
        <div class="form-header">
            <h2><i class="fas fa-route"></i> Cadastrar Nova Rota</h2>
            <p>Defina as informações básicas para o novo itinerário</p>
        </div>

        <form action="salvar_rota.php" method="POST">

            <div class="form-group">
                <label for="nome"><i class="fas fa-map-signs"></i> Nome da Rota</label>
                <input type="text" id="nome" name="nome" placeholder="Ex: Coleta Centro - Manhã" required>
            </div>

            <div class="form-group">
                <label for="descricao"><i class="fas fa-align-left"></i> Descrição (Opcional)</label>
                <textarea id="descricao" name="descricao"
                    placeholder="Detalhes sobre esta rota, horários ou observações importantes..."></textarea>
            </div>

            <div class="botoes-container">
                <a href="rotas.php" class="btn btn-voltar"><i class="fas fa-times"></i> Cancelar</a>
                <button type="submit" class="btn btn-salvar"><i class="fas fa-save"></i> Salvar Rota</button>
            </div>

        </form>
    </div>

</body>

</html>