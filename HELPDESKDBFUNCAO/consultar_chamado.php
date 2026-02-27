<?php
require_once 'verificaLogin.php';
require_once 'conexao.php';

$conn = conexao();

$busca = trim($_GET['busca'] ?? '');
$statusOptions = ['aberto', 'em andamento', 'concluido'];

if ($busca) {
  $buscaParam = "%$busca%";
  $sql = "SELECT chamados.*, user.nome 
            FROM chamados 
            JOIN user ON chamados.userId = user.id
            WHERE user.nome LIKE ? OR chamados.titulo LIKE ? OR chamados.categoria LIKE ?";

  $stmt = mysqli_prepare($conn, $sql);
  if (!$stmt)
    die("Erro no prepare: " . mysqli_error($conn));

  mysqli_stmt_bind_param($stmt, "sss", $buscaParam, $buscaParam, $buscaParam);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $chamados = mysqli_fetch_all($result, MYSQLI_ASSOC);

} else {
  $sql = "SELECT chamados.*, user.nome 
            FROM chamados 
            JOIN user ON chamados.userId = user.id";

  $result = mysqli_query($conn, $sql);
  if (!$result)
    die("Erro na query: " . mysqli_error($conn));

  $chamados = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

$statusOptions = ['aberto', 'em andamento', 'concluido'];
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
        <a href="home.php" type="button" class="btn btn-secondary" data-dismiss="modal">Voltar</a>
        <div class="card">

          <!-- Mensagens de sucesso/erro -->
          <?php if (isset($_GET['message'])): ?>
            <?php if ($_GET['message'] == 'success'): ?>
              <div class="alert alert-success" role="alert">Chamado atualizado com sucesso!</div>
            <?php elseif ($_GET['message'] == 'error'): ?>
              <div class="alert alert-danger" role="alert">Erro ao atualizar o chamado!</div>
            <?php endif; ?>
          <?php endif; ?>

          <?php if (isset($_GET['message1'])): ?>
            <?php if ($_GET['message1'] == 'success1'): ?>
              <div class="alert alert-success" role="alert">Chamado excluído com sucesso!</div>
            <?php elseif ($_GET['message1'] == 'error1'): ?>
              <div class="alert alert-danger" role="alert">Erro ao excluir o chamado!</div>
            <?php endif; ?>
          <?php endif; ?>

          <div class="card-header">Consulta de chamado</div>
          <form action="consultar_chamado.php" method="GET">
            <div class="mb-3">
              <label class="form-label">Pesquisa</label>
              <input type="text" name="busca" class="form-control"
                value="<?= htmlspecialchars($_GET['busca'] ?? '') ?>">
            </div>
            <button type="submit" class="btn btn-primary">Buscar</button>
          </form>

          <div class="card-body">
            <div class="row">

              <?php foreach ($chamados as $chamado):
                $ehDono = (int) $_SESSION['id'] === (int) $chamado['userId'];
                $ehAdmin = $_SESSION['nivel'] === 'admin' || $_SESSION['nivel'] === 'tecnico';

                if (!$ehDono && !$ehAdmin)
                  continue;
                ?>

                <div class="col-md-4 mb-4">
                  <div class="card bg-light h-100">
                    <div class="card-body">
                      <h5 class="card-title"><?= $chamado['nome'] ?></h5>
                      <h6><?= $chamado['titulo'] ?></h6>
                      <small class="text-muted"><?= $chamado['categoria'] ?></small>
                      <p class="mt-2"><?= $chamado['descricao'] ?></p>
                      <p><strong>Status:</strong> <?= $chamado['status'] ?? '' ?></p>
                      <?php if ($chamado['preco'] !== null): ?>
                        <p><strong>Preço:</strong> R$ <?= $chamado['preco'] ?></p>
                      <?php endif; ?>

                      <!-- Botão Editar -->
                      <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                        data-target="#editarChamadoModal" data-id="<?= $chamado['id'] ?>"
                        data-nome="<?= htmlspecialchars($chamado['nome']) ?>"
                        data-titulo="<?= htmlspecialchars($chamado['titulo']) ?>"
                        data-categoria="<?= htmlspecialchars($chamado['categoria']) ?>"
                        data-descricao="<?= htmlspecialchars($chamado['descricao']) ?>"
                        data-status="<?= $chamado['status'] ?>" data-preco="<?= $chamado['preco'] ?>">
                        Editar
                      </button>

                      <!-- Botão Excluir (mantido individual) -->
                      <button type="button" class="btn btn-danger" data-toggle="modal"
                        data-target="#excluirChamadoModal<?= $chamado['id'] ?>">
                        Excluir
                      </button>

                    </div>
                  </div>
                </div>

              <?php endforeach; ?>

            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  <!-- Modal único de edição -->
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
            <input type="hidden" name="id" id="modalChamadoId">

            <div class="form-group">
              <label>Nome</label>
              <input type="text" name="nome" class="form-control" id="modalChamadoNome" required readonly>
            </div>

            <div class="form-group">
              <label>Equipamento</label>
              <input type="text" name="titulo" class="form-control" id="modalChamadoTitulo" required>
            </div>

            <div class="form-group">
              <label>Categoria</label>
              <input type="text" name="categoria" class="form-control" id="modalChamadoCategoria" required>
            </div>

            <div class="form-group">
              <label>Descrição</label>
              <textarea name="descricao" class="form-control" id="modalChamadoDescricao" required></textarea>
            </div>

            <?php if ($_SESSION['nivel'] === 'admin' || $_SESSION['nivel'] === 'tecnico'): ?>
              <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control" id="modalChamadoStatus">
                  <?php foreach ($statusOptions as $status): ?>
                    <option value="<?= $status ?>"><?= ucfirst($status) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="form-group">
                <label>Preço</label>
                <input type="text" name="preco" class="form-control" id="modalChamadoPreco" required>
              </div>
            <?php endif; ?>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- jQuery, Popper e Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

  <!-- Script para popular o modal -->
  <script>
    $(document).ready(function () {
      $('#editarChamadoModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // botão que abriu o modal

        // Pega os dados do botão
        var id = button.data('id');
        var nome = button.data('nome');
        var titulo = button.data('titulo');
        var categoria = button.data('categoria');
        var descricao = button.data('descricao');
        var status = button.data('status');
        var preco = button.data('preco');

        // Popula os campos do modal
        $('#modalChamadoId').val(id);
        $('#modalChamadoNome').val(nome);
        $('#modalChamadoTitulo').val(titulo);
        $('#modalChamadoCategoria').val(categoria);
        $('#modalChamadoDescricao').val(descricao);

        <?php if ($_SESSION['nivel'] === 'admin' || $_SESSION['nivel'] === 'tecnico'): ?>
          $('#modalChamadoStatus').val(status);
          $('#modalChamadoPreco').val(preco);
        <?php endif; ?>
      });
    });
  </script>
</body>

</html>