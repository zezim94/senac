<?php
require_once 'verificaLogin.php';
require_once 'conexao.php';

$busca = trim($_GET['busca'] ?? '');

if ($busca) {

    $buscaParam = "%$busca%";

    $sql = "SELECT * FROM user 
            WHERE nome LIKE ? 
               OR usuario LIKE ? 
               OR email LIKE ?";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        die("Erro na busca: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "sss", $buscaParam, $buscaParam, $buscaParam);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $usuarios = mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_stmt_close($stmt);

} else {

    $sql = "SELECT * FROM user";
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

    <?php include 'nav.php'; ?>

    <div class="container">
        <div class="row">

            <div class="card-usuarios">
                <div class="card">
                    <form action="usuarios.php" method="GET">

                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Pesquisa</label>
                            <input type="text" name="busca" class="form-control" value="<?= htmlspecialchars($_GET['busca'] ?? '') ?>">
                        </div>

                        <button type="submit" class="btn btn-primary">Buscar</button>
                    </form>
                    <div class="card-header">
                        Lista de usuários
                    </div>

                    <div class="card-body">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>Senha</th>
                                    <th>Nivel</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                foreach ($usuarios as $user):

                                    $nivel = $user['nivel'];

                                    switch ($nivel) {
                                        case 'admin':
                                            $nivel = 'Administrador';
                                            break;
                                        case 'user':
                                            $nivel = 'Usuário';
                                            break;
                                        case 'tecnico':
                                            $nivel = 'Técnico';
                                            break;
                                    }

                                    ?>

                                    <tr>
                                        <td><?= $user['id'] ?></td>
                                        <td><?= $user['nome'] ?></td>
                                        <td><?= $user['email'] ?></td>
                                        <td><?= $user['senha'] ?></td>
                                        <td><?= $nivel ?></td>
                                        <td>
                                            <a href="processaEditarUser.php?id=<?= $user['id'] ?>"
                                                class="btn btn-warning btn-sm">Editar</a>
                                            <a href="processaExcluirUser.php?id=<?= $user['id'] ?>"
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('Tem certeza que deseja excluir <?= $user['nome'] ?>?')">Excluir</a>
                                        </td>
                                    </tr>

                                <?php endforeach; ?>
                            </tbody>
                        </table>

                        <div class="row mt-5">
                            <div class="col-6">
                                <a href="home.php" class="btn btn-lg btn-warning btn-block">Voltar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</body>

</html>