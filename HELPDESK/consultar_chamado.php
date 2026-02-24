<?php
include 'verificaLogin.php';

$linhas = file('arquivo.txt');
?>

<html>

<head>
  <meta charset="utf-8" />
  <title>App Help Desk</title>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

  <style>
    .card-consultar-chamado {
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

      <div class="card-consultar-chamado">
        <div class="card">
          <div class="card-header">
            Consulta de chamado
          </div>

          <div class="card-body">

            <?php

            foreach ($linhas as $linha):

              $dados = explode(' - ', $linha);

              if ($_SESSION['id'] != $dados[0] && $_SESSION['nivel'] != 'admin') {
                continue;
              }

              ?>

              <div class="card mb-3 bg-light">
                <div class="card-body">
                  <h4 class="card-title"><?= $dados[1] ?></h4>
                  <h5 class="card-title"><?= $dados[3] ?></h5>
                  <h6 class="card-subtitle mb-2 text-muted"><?= $dados[4] ?></h6>
                  <p class="card-text"><?= $dados[5] ?></p>

                </div>
              </div>

            <?php endforeach; ?>

            <div class="row mt-5">
              <div class="col-6">
                <a href="home.php" class="btn btn-lg btn-warning btn-block">Voltar</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>