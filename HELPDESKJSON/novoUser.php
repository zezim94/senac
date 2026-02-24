<?php
include 'verificaLogin.php';
?>

<html>

<head>
    <meta charset="utf-8" />
    <title>App Help Desk</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <style>
        .card-novo-user {
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

            <div class="card-novo-user">
                <div class="card">
                    <div class="card-header">
                        Novo Usuário
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">

                                <form action="processaNovoUser.php" method="post">
                                    <div class="form-group">
                                        <label>Nome</label>
                                        <input name="nome" type="text" class="form-control" placeholder="Nome">
                                    </div>

                                    <div class="form-group">
                                        <label>Email</label>
                                        <input name="email" type="email" class="form-control" placeholder="Email">
                                    </div>

                                    <div class="form-group">
                                        <label>Senha</label>
                                        <input name="senha" type="password" class="form-control" placeholder="Senha">
                                    </div>

                                    <div class="form-group">
                                        <label>Nível</label>
                                        <select name="nivel" class="form-control">
                                            <option value="user">Usuário</option>
                                            <option value="admin">Admin</option>
                                        </select>
                                    </div>

                                    <div class="row mt-5">
                                        <div class="col-6">
                                            <a href="home.php" class="btn btn-lg btn-warning btn-block">Voltar</a>
                                        </div>

                                        <div class="col-6">
                                            <button class="btn btn-lg btn-info btn-block" type="submit">Criar</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</body>

</html>