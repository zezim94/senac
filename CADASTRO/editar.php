<?php

require_once 'funcao/Usuario.php';
require_once 'DB/conexao.php';

$pdo = conecta();
$id = $_GET['id'];
$usuario = bucarUserPorId($pdo, $id);

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow" style="width: 400px;">
            <h3 class="text-center mb-3">Atualizar Usuário</h3>

            <form action="processaEditarUser.php" method="POST">
                <input type="hidden" name="id" value="<?= htmlspecialchars($usuario['id']) ?>"">
                <div class=" mb-3">
                <label class="form-label">Nome</label>
                <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($usuario['nome']) ?>"
                    placeholder="Seu nome">
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($usuario['email']) ?>"
                placeholder="Seu email">
        </div>

        <div class="mb-3">
            <label class="form-label">Senha</label>
            <input type="password" name="pass" class="form-control" placeholder="Crie uma senha">
        </div>

        <div class="mb-3">
            <label class="form-label">Confirmar Senha</label>
            <input type="password" name="confirmPass" class="form-control" placeholder="Confirme a senha">
        </div>

        <button type="submit" class="btn btn-success w-100">Atualizar</button>
        </form>

    </div>
    </div>

</body>

</html>