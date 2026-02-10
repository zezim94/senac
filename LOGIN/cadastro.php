<?php
session_start();
if (isset($_SESSION['msg'])) {
    echo "<p style='color:green'>" . $_SESSION['msg'] . "</p>";
    unset($_SESSION['msg']);
}
if (isset($_SESSION['erro'])) {
    echo "<p style='color:red'>" . $_SESSION['erro'] . "</p>";
    unset($_SESSION['erro']);
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
</head>

<body>

    <h1>Cadastro</h1>

    <form action="processa.php" method="POST">
        <input type="hidden" name="acao" value="cadastrar">
        <label for="usuario">Usuário</label>
        <input type="text" id="usuario" name="usuario">
        <br>
        <br>
        <label for="email">E-mail</label>
        <input type="email" id="email" name="email">
        <br>
        <br>
        <label for="nivel">Nível</label>
        <input type="number" id="nivel" name="nivel">
        <br>
        <br>
        <label for="senha">Senha</label>
        <input type="password" id="senha" name="senha">
        <br>
        <br>
        <input type="submit" value="Cadastrar">
        <br>
        <br>
        <a href="index.php">Login</a>
    </form>

</body>

</html>