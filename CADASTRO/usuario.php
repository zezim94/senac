<?php
session_start();
require_once 'funcao/Usuario.php';
require_once 'db/conexao.php';

$pdo = conecta();
$usuario = listarUser($pdo);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuários</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Painel</a>
            <div class="ms-auto d-flex align-items-center">
                <span class="text-light me-3">Olá, <?= $_SESSION['user'] ?></span>
                <a href="logout.php" class="btn btn-outline-light btn-sm">Sair</a>
            </div>
        </div>
    </nav>

    <!-- Conteúdo principal -->
    <div class="container mt-5">
        <h2 class="mb-4">Lista de Usuários</h2>

        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuario as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['nome']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td>
                                <a href="editar.php?id=<?= $user['id'] ?>">Editar</a>
                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#confirmDeleteModal" data-id="<?= $user['id'] ?>"
                                    data-nome="<?= $user['nome'] ?>">
                                    Excluir
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Confirmar Exclusão</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <p>Tem certeza que deseja excluir o usuário <strong id="nomeUsuario"></strong>?</p>
                </div>

                <div class="modal-footer">
                    <form method="POST" action="excluir.php">
                        <input type="hidden" value="<?=$user['id']?>" name="id" id="userId">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Excluir</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const modal = document.getElementById('confirmDeleteModal');

        modal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;

            const userId = button.getAttribute('data-id');
            const userName = button.getAttribute('data-nome');

            document.getElementById('userId').value = userId;
            document.getElementById('nomeUsuario').textContent = userName;
        });
    </script>
</body>

</html>