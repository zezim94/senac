<?php
require_once '../verificaLogin.php';
require_once '../FUNCAO/funcaoRelatorio.php';
require_once '../FUNCAO/funcaoChamado.php';
require_once '../conexao.php';

$conn = conexao();

$busca = trim($_GET['busca'] ?? '');

// CONTADORES
$aberto = relatorioAberto($conn);

$andamento = relatorioAndamento($conn);

$concluido = relatorioConcluido($conn);

// BUSCA
$usuarios = buscarTodos($conn, $busca)
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <title>Relatório - Help Desk</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <?php include '../LAYOUT/nav.php'; ?>

    <div class="container mt-4">

        <div class="card shadow">

            <!-- FILTROS -->
            <div class="card-body border-bottom">

                <label class="form-label fw-bold">Filtrar por status</label>

                <div class="d-flex flex-wrap gap-2">

                    <a href="relatorio.php?busca=aberto"
                        class="btn btn-primary <?= ($_GET['busca'] ?? '') === 'aberto' ? 'active' : '' ?>">
                        Aberto <span class="badge bg-light text-dark"><?= $aberto ?></span>
                    </a>

                    <a href="relatorio.php?busca=em andamento"
                        class="btn btn-warning <?= ($_GET['busca'] ?? '') === 'em andamento' ? 'active' : '' ?>">
                        Em andamento <span class="badge bg-dark"><?= $andamento ?></span>
                    </a>

                    <a href="relatorio.php?busca=concluido"
                        class="btn btn-success <?= ($_GET['busca'] ?? '') === 'concluido' ? 'active' : '' ?>">
                        Concluído <span class="badge bg-light text-dark"><?= $concluido ?></span>
                    </a>

                    <a href="relatorio.php" class="btn btn-secondary <?= empty($_GET['busca']) ? 'active' : '' ?>">
                        Todos
                    </a>

                </div>

            </div>

            <!-- HEADER -->
            <div class="card-header bg-dark text-white">
                Relatório de chamados
            </div>

            <!-- TABELA -->
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">

                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Usuário</th>
                                <th>Título</th>
                                <th>Categoria</th>
                                <th>Descrição</th>
                                <th>Status</th>
                                <th>Preço</th>
                                <th>Obs Técnico</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($usuarios as $user): ?>
                                <tr>
                                    <td><?= $user['id'] ?></td>
                                    <td><?= htmlspecialchars($user['usuario']) ?></td>
                                    <td><?= htmlspecialchars($user['titulo']) ?></td>
                                    <td><?= htmlspecialchars($user['categoria']) ?></td>
                                    <td><?= htmlspecialchars($user['descricao']) ?></td>
                                    <td>
                                        <?php
                                        $status = $user['status'];
                                        $badge = match ($status) {
                                            'aberto' => 'primary',
                                            'em andamento' => 'warning',
                                            'concluido' => 'success',
                                            default => 'secondary'
                                        };
                                        ?>
                                        <span class="badge bg-<?= $badge ?>">
                                            <?= $status ?>
                                        </span>
                                    </td>
                                    <td>R$ <?= number_format($user['preco'], 2, ',', '.') ?></td>
                                    <td><?= htmlspecialchars($user['statusTec']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>

                    </table>
                </div>

                <!-- VOLTAR -->
                <div class="row mt-4">
                    <div class="col-md-4">
                        <a href="../usuario/home.php" class="btn btn-warning w-100 btn-lg">
                            Voltar
                        </a>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- JS Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>