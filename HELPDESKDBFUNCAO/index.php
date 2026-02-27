<html>

<head>
  <meta charset="utf-8" />
  <title>App Help Desk</title>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

  <style>
    .card-login {
      padding: 30px 0 0 0;
      width: 350px;
      margin: 0 auto;
    }
  </style>
</head>

<body>

  <?php include 'nav.php'; ?>

  <div class="container">
    <div class="row">

      <div class="card-login">
        <div class="card">
          <div class="card-header">
            Login
          </div>
          <div class="card-body">
            <form action="processaLogin.php" method="post">
              <div class="form-group">
                <input name="email" type="text" class="form-control" placeholder="E-mail">
              </div>
              <div class="form-group">
                <input name="senha" type="password" class="form-control" placeholder="Senha">
              </div>
              <button class="btn btn-lg btn-info btn-block" type="submit">Entrar</button>
            </form>
            <?php
            if (isset($_GET['login']) && $_GET['login'] == 'erro'): ?>

              <div class="alert alert-danger" role="alert">
                Usuário ou senha inválidos !
              </div>

              <?php
            endif;
            unset($_GET['login']);
            ?>

             <?php
            if (isset($_GET['acesso']) && $_GET['acesso'] == 'invalido'): ?>

              <div class="alert alert-danger" role="alert">
                Necessario fazer login !
              </div>

              <?php
            endif;
            unset($_GET['acesso']);
            ?>
          </div>
        </div>
      </div>
    </div>
</body>

</html>