<?php
require_once '../verificaLogin.php';
require_once '../FUNCAO/funcaoUsuario.php';
require_once '../conexao.php';

$conn = conexao();

$busca = trim($_GET['busca'] ?? '');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nivel'], $_POST['id'])) {

    $nivel = ($_POST['nivel']) ?? '';
    $id = (int) ($_POST['id']) ?? 0;

    aprovar($conn, $nivel, $id);
}
$usuarios = buscarUsuario($conn, $busca);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <title>App Help Desk</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .card-usuarios {
            padding-top: 30px;
        }
    </style>
</head>

<body>

    <?php include '../LAYOUT/nav.php'; ?>

    <div class="container">

        <div class="card card-usuarios shadow">

            <!-- FORM DE BUSCA -->
            <div class="card-body border-bottom">
                <form action="usuarios.php" method="GET" class="row g-3">

                    <div class="col-md-10">
                        <label class="form-label">Pesquisar usuário</label>
                        <input type="text" name="busca" class="form-control"
                            placeholder="Digite nome, usuário ou email..."
                            value="<?= htmlspecialchars($_GET['busca'] ?? '') ?>">
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            Buscar
                        </button>
                    </div>

                </form>
            </div>

            <!-- HEADER -->
            <div class="card-header bg-dark text-white">
                Lista de usuários
            </div>

            <!-- TABELA -->
            <div class="card-body">

                <div class="table-responsive">


                    <table class="table table-striped table-hover align-middle">

                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Pedido Nível</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($usuarios as $user):

                                $nivel = $user['nivel'];

                                switch ($nivel) {
                                    case 'admin':
                                        $nivel = 'Administrador';
                                        break;
                                    case 'user':
                                        $nivel = 'Usuário';
                                        break;
                                    case 'tecnico':
                                        $nivel = 'Técnico';
                                        break;
                                }

                                if ($user['status']) {
                                    continue;
                                }
                                ?>
                                <tr>
                                    <td><?= $user['id'] ?></td>
                                    <td><?= htmlspecialchars($user['nome']) ?></td>
                                    <td><?= htmlspecialchars($user['email']) ?></td>
                                    <td><?= $nivel ?></td>

                                    <td class="text-center">
                                        <form method="POST">
                                            <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                            <input type="hidden" name="nivel" value="<?= $user['nivel'] ?>">
                                            <button class="btn btn-button">Aprovar</button>
                                        </form>
                                    </td>
                                </tr>

                            <?php endforeach; ?>
                        </tbody>

                    </table>
                </div>

                <!-- BOTÃO VOLTAR -->
                <div class="row mt-4">
                    <div class="col-md-4">
                        <a href="home.php" class="btn btn-warning w-100 btn-lg">
                            Voltar
                        </a>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <div class="modal fade" id="modalExcluir" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Confirmar Exclusão</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <p id="textoModal">Tem certeza que deseja excluir?</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancelar
                    </button>

                    <a id="btnConfirmarExcluir" href="#" class="btn btn-danger">
                        Excluir
                    </a>
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            var modal = document.getElementById('modalExcluir');

            modal.addEventListener('show.bs.modal', function (event) {

                var button = event.relatedTarget;

                var userId = button.getAttribute('data-id');
                var userNome = button.getAttribute('data-nome');

                var texto = document.getElementById('textoModal');
                var link = document.getElementById('btnConfirmarExcluir');

                texto.innerHTML = "Tem certeza que deseja excluir " + userNome + "?";

                link.href = "processaExcluirUser.php?id=" + userId;
            });

        });
    </script>

</body>

</html>