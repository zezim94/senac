<?php
include '../verificaLogin.php';

include '../conexao.php';

$conn = conexao();
$id = $_GET['id'] ?? null;

if (!$id) {
    die("ID não informado");
}

$sql = "SELECT * FROM user WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$usuario = mysqli_fetch_assoc($result);

if (!$usuario) {
    die("Usuário não encontrado");
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
            <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
            <div class="form-group">
                <label>Nome</label>
                <input type="text" name="nome" class="form-control" value="<?= $usuario['nome'] ?>" required>
            </div>
            <div class="form-group">
                <label>Usuário</label>
                <input type="text" name="usuario" class="form-control" value="<?= $usuario['usuario'] ?>" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?= $usuario['email'] ?>" required>
            </div>
            <div class="form-group">
                <label>Senha</label>
                <input type="text" name="senha" class="form-control">
            </div>
            <div class="form-group">
                <label>Nível</label>
                <select name="nivel" class="form-control">
                    <option value="user" <?= $usuario['nivel'] === 'user' ? 'selected' : '' ?>>Usuário</option>
                    <option value="admin" <?= $usuario['nivel'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="tecnico" <?= $usuario['nivel'] === 'tecnico' ? 'selected' : '' ?>>Técnico</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Salvar</button>
            <a href="usuarios.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>

</html>