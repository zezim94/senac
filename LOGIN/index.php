<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>

    <h1>Login</h1>
    <?php
    if (isset($_SESSION['msg'])) {
        echo "<p style='color:green'>" . $_SESSION['msg'] . "</p>";
        unset($_SESSION['msg']);
    }
    if (isset($_SESSION['erro'])) {
        echo "<p style='color:red'>" . $_SESSION['erro'] . "</p>";
        unset($_SESSION['erro']);
    }

    ?>

    <form action="processa.php" method="POST">
        <input type="hidden" name="acao" value="login">
        <label for="usuario">Usuário:</label>
        <input type="text" id="usuario" name="usuario">
        <br>
        <br>
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email">
        <br>
        <br>
        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha">
        <br>
        <br>
        <input type="submit" value="Enviar">
        <br>
        <br>
        <a href="cadastro.php">Cadastrar-se</a>

    </form>

</body>

</html>