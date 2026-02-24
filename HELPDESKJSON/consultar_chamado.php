<?php
include 'verificaLogin.php';

$arquivos = file_get_contents('arquivo.JSON');
$chamados = json_decode($arquivos, true);
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

            foreach ($chamados as $chamado):
              $ehDono = (int) $_SESSION['id'] === (int) $chamado['id'];
              $ehAdmin = $_SESSION['nivel'] === 'admin' || $_SESSION['nivel'] === 'tecnico';

              if (!$ehDono && !$ehAdmin) {
                continue;
              }

              ?>

              <div class="card mb-3 bg-light">
                <div class="card-body">
                  <h4 class="card-title"><?= $chamado['nome'] ?></h4>
                  <h5 class="card-title"><?= $chamado['equipamento'] ?></h5>
                  <h6 class="card-subtitle mb-2 text-muted"><?= $chamado['categoria'] ?></h6>
                  <p class="card-text"><?= $chamado['descricao'] ?></p>

                  <form action="processaEditarChamado.php" method="POST">
                    <input type="hidden" name="id" value="<?= $chamado['id'] ?>">
                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editarChamadoModal"
                      data-id="<?= $chamado['id'] ?>" data-nome="<?= htmlspecialchars($chamado['nome'], ENT_QUOTES) ?>"
                      data-equipamento="<?= htmlspecialchars($chamado['equipamento'], ENT_QUOTES) ?>"
                      data-categoria="<?= htmlspecialchars($chamado['categoria'], ENT_QUOTES) ?>"
                      data-descricao="<?= htmlspecialchars($chamado['descricao'], ENT_QUOTES) ?>">
                      Editar
                    </button>
                  </form>

                  <form action="processaExcluirChamado.php" method="POST">
                    <input type="hidden" name="id" value="<?= $chamado['id'] ?>">
                    <button type="submit" class="btn btn-danger">Excluir</button>
                  </form>

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
  <!-- Modal -->
  <div class="modal fade" id="editarChamadoModal" tabindex="-1" role="dialog" aria-labelledby="editarChamadoLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form action="processaEditarChamado.php" method="POST">
          <div class="modal-header">
            <h5 class="modal-title" id="editarChamadoLabel">Editar Chamado</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="id" id="chamadoId">

            <div class="form-group">
              <label>Nome</label>
              <input type="text" name="nome" class="form-control" id="chamadoNome" required>
            </div>

            <div class="form-group">
              <label>Equipamento</label>
              <input type="text" name="equipamento" class="form-control" id="chamadoEquipamento" required>
            </div>

            <div class="form-group">
              <label>Categoria</label>
              <input type="text" name="categoria" class="form-control" id="chamadoCategoria" required>
            </div>

            <div class="form-group">
              <label>Descrição</label>
              <textarea name="descricao" class="form-control" id="chamadoDescricao" required></textarea>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

<script>
$('#editarChamadoModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // botão que abriu o modal
    var id = button.data('id');
    var nome = button.data('nome');
    var equipamento = button.data('equipamento');
    var categoria = button.data('categoria');
    var descricao = button.data('descricao');

    var modal = $(this);
    modal.find('#chamadoId').val(id);
    modal.find('#chamadoNome').val(nome);
    modal.find('#chamadoEquipamento').val(equipamento);
    modal.find('#chamadoCategoria').val(categoria);
    modal.find('#chamadoDescricao').val(descricao);
});
</script>

</body>

</html>