<?php
include 'verificaLogin.php';

$arquivo = file_get_contents('login.JSON');
$usuarios = json_decode($arquivo, true);

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

                                    $nivel = $user['Nivel'];

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
                                <td><?= $user['ID'] ?></td>
                                <td><?= $user['Nome'] ?></td>
                                <td><?= $user['Email'] ?></td>
                                <td><?= $user['Senha'] ?></td>
                                <td><?= $nivel ?></td>
                                <td>
                                    <a href="processaEditarUser.php?id=<?= $user['ID'] ?>" class="btn btn-warning btn-sm">Editar</a>
                                    <a href="processaExcluirUser.php?id=<?= $user['ID'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir <?= $user['Nome'] ?>?')">Excluir</a>
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