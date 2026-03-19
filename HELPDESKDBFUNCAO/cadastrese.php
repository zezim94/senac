<html>

<head>
    <meta charset="utf-8" />
    <title>App Help Desk</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .card-novo-user {
            padding: 30px 0 0 0;
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="img/logo.png" width="30" height="30" class="d-inline-block align-text-top" alt="">
                App Help Desk
            </a>

            <?php if (isset($_SESSION['logado']) && $_SESSION['logado'] == true) { ?>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../logout.php">SAIR</a>
                    </li>
                </ul>
            <?php } ?>
        </div>
    </nav>

    <div class="container">
        <div class="card-novo-user">
            <div class="card">

                <?php if (isset($_GET['message']) && $_GET['message'] === 'sucess'): ?>
                    <div class="alert alert-success text-center" role="alert">
                        Usuário cadastrado com sucesso!
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['message']) && $_GET['message'] === 'error'): ?>
                    <div class="alert alert-danger text-center" role="alert">
                        Erro ao cadastrar o usuário!
                    </div>
                <?php endif; ?>

                <div class="card-body">
                    <form action="processaCadastro.php" method="post">
                        <div class="mb-3">
                            <label class="form-label">Nome</label>
                            <input name="nome" type="text" class="form-control" placeholder="Nome" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Usuário</label>
                            <input name="usuario" type="text" class="form-control" placeholder="Usuário" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input name="email" type="email" class="form-control" placeholder="Email" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Senha</label>
                            <input name="senha" type="password" class="form-control" placeholder="Senha" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nível</label>
                            <select name="nivel" class="form-select">
                                <option value="user">Usuário</option>
                                <option value="admin">Admin</option>
                                <option value="tecnico">Técnico</option>
                            </select>
                        </div>

                        <div class="row mt-4">
                            <div class="col-6 d-grid">
                                <a href="index.php" class="btn btn-warning btn-lg">Voltar</a>
                            </div>
                            <div class="col-6 d-grid">
                                <button class="btn btn-info btn-lg" type="submit">Cadastre-se</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-c6Eg+E2k33d4D1WZqB9c6pjsdfuH2FqHZb+pc0gkVsaYV2L4k7tW2U9aENvZ45wX"
        crossorigin="anonymous"></script>

</body>

</html>