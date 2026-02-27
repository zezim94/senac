<?php
require_once 'verificaLogin.php';

require_once 'conexao.php';

$sql = "SELECT chamados.*, user.nome FROM chamados join user on chamados.userId = user.id";

$chamados = mysqli_query($conn, $sql);

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
          <?php
          if (isset($_GET['message']) && $_GET['message'] == 'success'): ?>

            <div class="alert alert-success" role="alert">
              Chamado atualizado com sucesso !
            </div>

            <?php
          elseif (isset($_GET['message']) && $_GET['message'] == 'error'):
            unset($_GET['message']);
            ?>

            <div class="alert alert-danger" role="alert">
              Erro ao atualizar o chamado!
            </div>

            <?php
          endif;
          unset($_GET['message']);
          ?>
          <div class="card-header">
            Consulta de chamado
          </div>

          <div class="card-body">

            <div class="row">

              <?php foreach ($chamados as $chamado):

                $ehDono = (int) $_SESSION['id'] === (int) $chamado['id'];
                $ehAdmin = $_SESSION['nivel'] === 'admin' || $_SESSION['nivel'] === 'tecnico';

                if (!$ehDono && !$ehAdmin) {
                  continue;
                }
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

                      <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                        data-target="#editarChamadoModal" data-id="<?= $chamado['id'] ?>">
                        Editar
                      </button>



                      <button type="submit" class="btn btn-danger btn-sm" data-toggle="modal"
                        data-target="#excluirChamadoModal">
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
            <input type="hidden" name="id" value="<?= $chamado['id'] ?>">

            <div class="form-group">
              <label>Nome</label>
              <input type="text" name="nome" class="form-control" value="<?= $chamado['nome'] ?>" required>
            </div>

            <div class="form-group">
              <label>Equipamento</label>
              <input type="text" name="titulo" class="form-control" value="<?= $chamado['titulo'] ?>" required>
            </div>

            <div class="form-group">
              <label>Categoria</label>
              <input type="text" name="categoria" class="form-control" value="<?= $chamado['categoria'] ?>" required>
            </div>

            <div class="form-group">
              <label>Descrição</label>
              <textarea name="descricao" class="form-control" required><?= $chamado['descricao'] ?></textarea>
            </div>

            <div class="form-group">
              <label>Status</label>
              <?php $statusAtual = $chamado['status']; ?>
              <select name="status" class="form-control">
                <?php foreach ($statusOptions as $status): ?>
                  <option value="<?= $status ?>" <?= $statusAtual === $status ? 'selected' : '' ?>>
                    <?= ucfirst($status) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="form-group">
              <label>Preço</label>
              <input type="text" name="preco" class="form-control" id="chamadoPreco" value="<?= $chamado['preco'] ?>"
                required>
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

  <div class="modal fade" id="excluirChamadoModal" tabindex="-1" role="dialog" aria-labelledby="excluirChamadoLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form action="processaExcluirChamado.php" method="POST">
          <input type="hidden" name="id" value="<?= $chamado['id'] ?>">

          <div class="alert alert-danger" role="alert">
            Tem certeza que deseja excluir esse chamado ?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-danger">Confirmar exclusão</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>



</body>

</html>