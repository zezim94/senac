<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinema</title>
</head>

<body>
    <h1>Avatar: Fogo e Cinzas</h1>

    <form action="processa.php" method="POST">

        <label for="name">Nome:</label>
        <input type="text" id="name" name="name" required>
        <br><br>
        <label for="idade">Idade:</label>
        <input type="number" id="idade" name="idade" required>
        <br><br>
        <label for="sexo">Sexo:</label>
        <input type="radio" id="sexo" name="sexo" value="Masculino">
        <label for="sexo">Masculino</label>
        <input type="radio" id="sexo" name="sexo" value="Feminino">
        <label for="sexo">Feminino</label>
        <br><br>
        <label for="nota">O que você achou do filme?</label>
        <select name="nota">
            <option value="excelente">Excelente</option>
            <option value="bom">Bom</option>
            <option value="regular">Regular</option>
            <option value="pessimo">Péssimo</option>
        </select>
        <br><br>
        <input type="submit" value="Enviar">
    </form>

    <a href="limpar.php">Limpar</a>
    <?php

    if (isset($_SESSION['media_idade'])) {
        echo "<h2>Resultado:</h2>";
        echo "Total de pessoas: " . $_SESSION['total_pessoas'] . "<br>";
        echo "<hr>";
        echo "Total de homens: " . number_format($_SESSION['mas'], 2) . "%" . "<br>";
        echo "Total de mulheres: " . number_format($_SESSION['fem'], 2) . "%" . "<br>";
        echo "<hr>";
        echo "Total de excelentes: " . number_format($_SESSION['excelente'], 2) . "%" . "<br>";
        echo "Total de bons: " . number_format($_SESSION['bom'], 2) . "%" . "<br>";
        echo "Total de regulares: " . number_format($_SESSION['regular'], 2) . "%" . "<br>";
        echo "Total de péssimos: " . number_format($_SESSION['pessimo'], 2) . "%" . "<br>";
        echo "<hr>";
        echo "Média de idade: " . number_format($_SESSION['media_idade'], 2) . "<br>";
    }
    ?>


</body>

</html>