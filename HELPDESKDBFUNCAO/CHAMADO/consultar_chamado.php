<?php
require_once '../verificaLogin.php';
require_once '../FUNCAO/funcaoChamado.php';
require_once '../conexao.php';

$conn = conexao();

$busca = trim($_GET['busca'] ?? '');
$statusOptions = ['aberto', 'em andamento', 'concluido'];

$chamados = buscarTodos($conn, $busca);
$chamadoEditar = null;

if (isset($_GET['editar'])) {
  $idEditar = $_GET['editar'];
  $chamadoEditar = buscarPorId($conn, $idEditar);
}
$chamadoExcluir = null;

if (isset($_GET['excluir'])) {
  $idExcluir = $_GET['excluir'];
  $chamadoExcluir = buscarPorId($conn, $idExcluir);
}
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

  <?php include '../LAYOUT/nav.php'; ?>

  <div class="container">
    <div class="row">
      <div class="card-consultar-chamado">
        <a href="../USUARIO/home.php" type="button" class="btn btn-secondary" data-dismiss="modal">Voltar</a>
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

              <?php if (!empty($chamados) && is_array($chamados)): ?>
                <?php foreach ($chamados as $chamado):
                  $ehDono = (int) $_SESSION['id'] === (int) $chamado['userId'];
                  $ehAdmin = $_SESSION['nivel'] === 'admin' || $_SESSION['nivel'] === 'tecnico';

                  if (!$ehDono && !$ehAdmin)
                    continue;
                  ?>

                  <div class="col-md-4 mb-4">
                    <div class="card bg-light h-100">
                      <div class="card-body">
                        <h5 class="card-title"><?= $chamado['usuario'] ?></h5>
                        <h6><?= $chamado['titulo'] ?></h6>
                        <small class="text-muted"><?= $chamado['categoria'] ?></small>
                        <p class="mt-2"><?= $chamado['descricao'] ?></p>
                        <p><strong>Status:</strong> <?= $chamado['status'] ?? '' ?></p>
                        <?php if ($chamado['preco'] !== null): ?>
                          <p><strong>Preço:</strong> R$ <?= $chamado['preco'] ?></p>
                          <p><strong>Observacao: </strong><?= $chamado['statusTec'] ?></p>
                        <?php endif; ?>


                        <?php if ($chamado['status'] == 'aberto' || $ehAdmin): ?>

                          <a href="consultar_chamado.php?editar=<?= $chamado['id'] ?>" class="btn btn-warning btn-sm">
                            Editar
                          </a>

                          <a href="consultar_chamado.php?excluir=<?= $chamado['id'] ?>" class="btn btn-danger btn-sm">
                            Excluir
                          </a>
                        <?php endif; ?>

                      </div>
                    </div>
                  </div>

                <?php endforeach; ?>
              <?php else: ?>
                <p>Nenhum chamado encontrado.</p>
              <?php endif; ?>

            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  <!-- Modal Excluir -->
  <div class="modal fade" id="excluirChamadoModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">

      <form action="processaExcluirChamado.php" method="POST" class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title">Confirmar Exclusão</h5>
          <a href="consultar_chamado.php" class="close">
            <span>&times;</span>
          </a>
        </div>

        <div class="modal-body">

          <input type="hidden" name="id" value="<?= $chamadoExcluir['id'] ?? '' ?>">

          <p>Tem certeza que deseja excluir o chamado:</p>

          <strong>
            <?= $chamadoExcluir['titulo'] ?? '' ?>
          </strong>

        </div>

        <div class="modal-footer">
          <a href="consultar_chamado.php" class="btn btn-secondary">
            Cancelar
          </a>

          <button type="submit" class="btn btn-danger">
            Excluir
          </button>
        </div>

      </form>

    </div>
  </div>
  <!-- Modal único de edição -->
  <div class="modal fade" id="editarChamadoModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">

        <form action="processaEditarChamado.php" method="POST">

          <div class="modal-header">
            <h5 class="modal-title">Editar Chamado</h5>
            <a href="consultar_chamado.php" class="close">
              <span>&times;</span>
            </a>
          </div>

          <div class="modal-body">

            <input type="hidden" name="id" value="<?= $chamadoEditar['id'] ?? '' ?>">

            <div class="form-group">
              <label>Nome</label>
              <input type="text" name="nome" class="form-control" value="<?= $chamadoEditar['usuario'] ?? '' ?>"
                readonly>
            </div>

            <div class="form-group">
              <label>Equipamento</label>
              <input type="text" name="titulo" class="form-control" required
                value="<?= $chamadoEditar['titulo'] ?? '' ?>">
            </div>

            <div class="form-group">
              <label>Categoria</label>

              <select name="categoria" class="form-control">

                <option value="criação_usuario" <?= ($chamadoEditar['categoria'] ?? '') == 'criação_usuario' ? 'selected' : '' ?>>
                  Criação Usuário
                </option>

                <option value="impressora" <?= ($chamadoEditar['categoria'] ?? '') == 'impressora' ? 'selected' : '' ?>>
                  Impressora
                </option>

                <option value="hardware" <?= ($chamadoEditar['categoria'] ?? '') == 'hardware' ? 'selected' : '' ?>>
                  Hardware
                </option>

                <option value="software" <?= ($chamadoEditar['categoria'] ?? '') == 'software' ? 'selected' : '' ?>>
                  Software
                </option>

                <option value="rede" <?= ($chamadoEditar['categoria'] ?? '') == 'rede' ? 'selected' : '' ?>>
                  Rede
                </option>

              </select>
            </div>

            <div class="form-group">
              <label>Descrição</label>
              <textarea name="descricao" class="form-control"><?=
                $chamadoEditar['descricao'] ?? '' ?></textarea>
            </div>

            <div class="form-group">
              <label>Observação</label>
              <textarea name="observacao" class="form-control"><?=
                $chamadoEditar['statusTec'] ?? '' ?></textarea>
            </div>

            <?php if ($_SESSION['nivel'] === 'admin' || $_SESSION['nivel'] === 'tecnico'): ?>

              <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control">

                  <?php foreach ($statusOptions as $status): ?>
                    <option value="<?= $status ?>" <?= (isset($chamadoEditar['status']) && $chamadoEditar['status'] == $status) ? 'selected' : '' ?>>
                      <?= ucfirst($status) ?>
                    </option>
                  <?php endforeach; ?>

                </select>
              </div>

              <div class="form-group">
                <label>Preço</label>
                <input type="text" name="preco" class="form-control" value="<?= $chamadoEditar['preco'] ?? '' ?>">
              </div>

            <?php endif; ?>

          </div>

          <div class="modal-footer">
            <a href="consultar_chamado.php" class="btn btn-secondary">Cancelar</a>
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

  <?php if (!empty($chamadoEditar)): ?>
    <script>
      $('#editarChamadoModal').modal('show');
    </script>
  <?php endif; ?>
  <?php if (!empty($chamadoExcluir)): ?>
    <script>
      $('#excluirChamadoModal').modal('show');
    </script>
  <?php endif; ?>
</body>

</html>