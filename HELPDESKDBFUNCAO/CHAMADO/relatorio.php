<?php
require_once '../verificaLogin.php';
require_once '../conexao.php';

$conn = conexao();

$busca = trim($_GET['busca'] ?? '');

$sqlAberto = "SELECT COUNT(*) AS total FROM chamados WHERE status = 'aberto'";
$resultAberto = mysqli_query($conn, $sqlAberto);
$aberto = mysqli_fetch_assoc($resultAberto)['total'];

$sqlAndamento = "SELECT COUNT(*) AS total FROM chamados WHERE status = 'em andamento'";
$resultAndamento = mysqli_query($conn, $sqlAndamento);
$andamento = mysqli_fetch_assoc($resultAndamento)['total'];

$sqlConcluido = "SELECT COUNT(*) AS total FROM chamados WHERE status = 'concluido'";
$resultConcluido = mysqli_query($conn, $sqlConcluido);
$concluido = mysqli_fetch_assoc($resultConcluido)['total'];

if ($busca) {

    $buscaParam = "%$busca%";

    $sql = "SELECT c.*, u.nome as usuario FROM chamados c
            left join user u on c.userId = u.id
            WHERE c.status LIKE ? ";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        die("Erro na busca: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "s", $buscaParam);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $usuarios = mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_stmt_close($stmt);

} else {


    $sql = "SELECT c.*, u.nome as usuario FROM chamados c
            left join user u on c.userId = u.id";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Erro na busca: " . mysqli_error($conn));
    }

    $usuarios = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Garante que sempre será array
if (!$usuarios) {
    $usuarios = [];
}
?>

<html>

<head>
    <meta charset="utf-8" />
    <title>App Help Desk</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <style>
        .card-usuarios {
            padding: 30px 0 0 0;
            width: 100%;
            margin: 0 auto;
        }
    </style>
</head>

<body>

    <?php include '../LAYOUT/nav.php'; ?>

    <div class="container">
        <div class="row">

            <div class="card-usuarios">
                <div class="card">
                    <form action="relatorio.php" method="GET">

                        <div class="mb-3">
                            <label class="form-label">Filtrar por status</label><br>
                            <a href="relatorio.php?busca=aberto"
                                class="btn btn-primary <?= ($_GET['busca'] ?? '') === 'aberto' ? 'active' : '' ?>">
                                Aberto (<?= $aberto ?>)
                            </a>
                            <a href="relatorio.php?busca=em andamento"
                                class="btn btn-warning <?= ($_GET['busca'] ?? '') === 'em andamento' ? 'active' : '' ?>">
                                Em andamento (<?= $andamento ?>)
                            </a>
                            <a href="relatorio.php?busca=concluido"
                                class="btn btn-success <?= ($_GET['busca'] ?? '') === 'concluido' ? 'active' : '' ?>">
                                Concluído (<?= $concluido ?>)
                            </a>
                            <a href="relatorio.php"
                                class="btn btn-secondary <?= empty($_GET['busca']) ? 'active' : '' ?>">Todos</a>
                        </div>
                    </form>
                    <div class="card-header">
                        Lista de usuários
                    </div>

                    <div class="card-body">
                        <table class="table table-striped table-hover">
                            <thead>
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
                                <?php

                                foreach ($usuarios as $user):


                                    ?>

                                    <tr>
                                        <td><?= $user['id'] ?></td>
                                        <td><?= $user['usuario'] ?></td>
                                        <td><?= $user['titulo'] ?></td>
                                        <td><?= $user['categoria'] ?></td>
                                        <td><?= $user['descricao'] ?></td>
                                        <td><?= $user['status'] ?></td>
                                        <td><?= $user['preco'] ?></td>
                                        <td><?= $user['statusTec'] ?></td>
                                        <td>

                                        </td>
                                    </tr>

                                <?php endforeach; ?>
                            </tbody>
                        </table>

                        <div class="row mt-5">
                            <div class="col-6">
                                <a href="../usuario/home.php" class="btn btn-lg btn-warning btn-block">Voltar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</body>

</html>