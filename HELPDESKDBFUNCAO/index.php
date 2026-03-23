<?php
session_start();
?>

<html>

<head>
  <meta charset="utf-8" />
  <title>App Help Desk</title>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    .card-login {
      padding: 30px 0 0 0;
      width: 350px;
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
    <div class="row justify-content-center">

      <div class="card-login">
        <div class="card">
          <div class="card-header text-center">
            Login
          </div>
          <div class="card-body">
            <form action="processaLogin.php" method="post">
              <div class="mb-3">
                <input name="email" type="text" class="form-control" placeholder="E-mail" required>
              </div>
              <div class="mb-3">
                <input name="senha" type="password" class="form-control" placeholder="Senha" required>
              </div>
              <button class="btn btn-info w-100 mb-2" type="submit">Entrar</button>
            </form>

            <a href="cadastrese.php" class="btn btn-outline-info w-100 mb-3">Cadastre-se</a>

            <?php if (isset($_GET['login']) && $_GET['login'] == 'erro'): ?>
              <div class="alert alert-danger text-center" role="alert">
                Usuário ou senha inválidos!
              </div>
            <?php endif;
            unset($_GET['login']); ?>

            <?php if (isset($_GET['acesso']) && $_GET['acesso'] == 'invalido'): ?>
              <div class="alert alert-danger text-center" role="alert">
                Necessário fazer login!
              </div>
            <?php endif;
            unset($_GET['acesso']); ?>
          </div>
        </div>
      </div>

    </div>
  </div>

  <!-- Bootstrap 5 JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-c6Eg+E2k33d4D1WZqB9c6pjsdfuH2FqHZb+pc0gkVsaYV2L4k7tW2U9aENvZ45wX"
    crossorigin="anonymous"></script>

</body>

</html>