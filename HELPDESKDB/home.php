<?php
require_once 'verificaLogin.php';
require_once 'conexao.php';

$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM user");
$row = mysqli_fetch_assoc($result);
$totalUser = $row['total'];

// Total de chamados
$result2 = mysqli_query($conn, "SELECT COUNT(*) AS total FROM chamados");
$row2 = mysqli_fetch_assoc($result2);
$totalChamado = $row2['total'];

?>

<html>

<head>
  <meta charset="utf-8" />
  <title>App Help Desk</title>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

  <style>
    .card-home {
      padding: 30px 0 0 0;
      width: 100%;
      margin: 0 auto;
    }

    span {
      position: absolute;
      right: 130px;
      top: -10px;
      background-color: red;
      color: white;
      font-weight: bold;
      border-radius: 50%;
      width: 20px;
      height: 20px;
      display: flex;
      justify-content: center;
      align-items: center;
    }
  </style>
</head>

<body>

  <?php include 'nav.php'; ?>

  <div class="container">
    <div class="row">

      <div class="card-home">
        <div class="card">
          <?php if (isset($_SESSION['logado']) && $_SESSION['logado'] == true) { ?>
            <h2 class="text-center">Olá, <?= $_SESSION['nome'] ?></h2>
          <?php } ?>
          <div class="card-header">
            Menu
          </div>
          <div class="card-body">
            <div class="row">

              <div class="col-3 d-flex justify-content-center">
                <a href="abrir_chamado.php">
                  <img src="img/formulario_abrir_chamado.png" width="70" height="70">
                </a>
              </div>

              <div class="col-3 d-flex justify-content-center">
                <a href="consultar_chamado.php">

                  <?php if ($_SESSION['nivel'] == 'admin' || $_SESSION['nivel'] == 'tecnico'): ?>
                    <span><?= $totalChamado ?></span>
                  <?php endif; ?>

                  <img src="img/formulario_consultar_chamado.png" width="70" height="70">
                </a>
              </div>

              <?php if ($_SESSION['nivel'] == 'admin') { ?>
                <div class="col-3 d-flex justify-content-center">
                  <a href="novoUser.php">
                    <img src="img/novoUser.png" width="70" height="70">
                  </a>
                </div>
              <?php } ?>

              <?php if ($_SESSION['nivel'] == 'admin') { ?>
                <div class="col-3 d-flex justify-content-center">
                  <a href="usuarios.php">
                    <?php echo "<span>" . $totalUser . "</span>" ?>
                    <img src="img/user.png" width="70" height="70">
                  </a>
                </div>
              <?php } ?>

            </div>
          </div>
        </div>
      </div>
    </div>
</body>

</html>