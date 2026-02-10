<?php
session_start();

$dados = $_SESSION['dados'] ?? [];

?>

<!DOCTYPE html>
<html lang="pt-br">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IMC</title>
</head>

<body>

    <h1>IMC</h1>

    <?php

    if (!empty($_SESSION['erro'])):
        ?>
        <hr>
        <p style="color: red">
            <?= $_SESSION['erro'] ?>
        </p>
        <hr>

        <?php
        unset($_SESSION['erro']);
    endif;
    ?>

    <form action="processa.php" method="post">

        <label for="name">Nome:</label>
        <input type="text" id="name" name="name" value="<?= $dados['name'] ?? '' ?>">

        <label for="peso">Pesso:</label>
        <input type="number" id="peso" name="peso" value="<?= $dados['peso'] ?? '' ?>">

        <label for="altura">Altura:</label>
        <input type="number" id="altura" name="altura" step='0.01' value="<?= $dados['altura'] ?? '' ?>">


        <input type="submit">
        <br>
        <hr>

    </form>

    <?php

    if (isset($_GET['erro'])) {
        echo $_GET['erro'];
        unset($_GET['erro']);
    }

    if (isset($_SESSION['resultado'])) {
        echo "Olá: " . $_SESSION['dados']['name'] . "<br>";
        echo "Peso: " . $_SESSION['dados']['peso'] . "<br>";
        echo "Altura: " . $_SESSION['dados']['altura'] . "<br>";
        echo "Seu IMC é: " . number_format($_SESSION['resultado'], 2) . "<br>";
        echo "Classe: " . ($_SESSION['class']);

        unset($_SESSION['dados']);
        unset($_SESSION['resultado']);
        unset($_SESSION['class']);
    }

    ?>

</body>

</html>