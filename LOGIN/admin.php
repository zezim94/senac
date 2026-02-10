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
    <title>Document</title>
</head>

<body>

    <h1>Bem-vindo, <?php echo $_SESSION['usuario_nome']; ?>!</h1>

</body>

</html>