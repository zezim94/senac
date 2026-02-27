<?php
include 'verificaLogin.php';

if (!isset($_GET['id'])) {
    header('Location: listarUsuarios.php'); // se não veio ID, volta
    exit;
}

$idEditar = (int)$_GET['id'];

// Ler JSON
$arquivo = file_get_contents('login.JSON');
$usuarios = json_decode($arquivo, true);

// Procurar usuário pelo ID
$usuario = null;
foreach ($usuarios as $user) {
    if ((int)$user['ID'] === $idEditar) {
        $usuario = $user;
        break;
    }
}

if (!$usuario) {
    die("Usuário não encontrado!");
}
?>

<html>
<head>
    <meta charset="utf-8">
    <title>Editar Usuário</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Editar Usuário</h2>
    <form action="salvarEdicao.php" method="post">
        <input type="hidden" name="id" value="<?= $usuario['ID'] ?>">
        <div class="form-group">
            <label>Nome</label>
            <input type="text" name="nome" class="form-control" value="<?= $usuario['Nome'] ?>" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?= $usuario['Email'] ?>" required>
        </div>
        <div class="form-group">
            <label>Senha</label>
            <input type="text" name="senha" class="form-control" value="<?= $usuario['Senha'] ?>" required>
        </div>
        <div class="form-group">
            <label>Nível</label>
            <select name="nivel" class="form-control">
                <option value="user" <?= $usuario['Nivel'] === 'user' ? 'selected' : '' ?>>Usuário</option>
                <option value="admin" <?= $usuario['Nivel'] === 'admin' ? 'selected' : '' ?>>Admin</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="usuarios.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>