<?php
session_start();
$selecionado = $_SESSION['personagem'] ?? '';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Personagens</title>
</head>

<body>

    <div class="container">
        <form action="funcao.php" method="POST">
            <select name="personagem" id="personagens">
                <option value="">Selecione um personagem...</option>

                <option value="Mickey" <?= $selecionado == 'Mickey' ? 'selected' : '' ?>>Mickey Mouse</option>
                <option value="SpongeBob" <?= $selecionado == 'SpongeBob' ? 'selected' : '' ?>>Bob Esponja</option>
                <option value="Goku" <?= $selecionado == 'Goku' ? 'selected' : '' ?>>Goku</option>
                <option value="Naruto" <?= $selecionado == 'Naruto' ? 'selected' : '' ?>>Naruto</option>
                <option value="Batman" <?= $selecionado == 'Batman' ? 'selected' : '' ?>>Batman</option>
                <option value="Elsa" <?= $selecionado == 'Elsa' ? 'selected' : '' ?>>Elsa</option>
                <option value="Shrek" <?= $selecionado == 'Shrek' ? 'selected' : '' ?>>Shrek</option>
                <option value="Homer" <?= $selecionado == 'Homer' ? 'selected' : '' ?>>Homer Simpson</option>
            </select>
            <input type="submit" value="Enviar">
        </form>

        <div class="exibir">
            <?php

            if (isset($_SESSION['img'])) { ?>
                <div class="img">
                   <img src="<?= $_SESSION['img'] ?>" alt="<?= $_SESSION['nome'] ?>">
                    <div class="nome">
                        <p> <?= $_SESSION['nome'] ?> </p>
                    </div>
                </div>


                <div class="detalhes">
                    <div class="descricao">
                        <h3>Descrição:</h3>
                        <p> <?= $_SESSION['descricao'] ?> </p>
                    </div>

                    <div class="caracteristicas">
                        <h3>Caracteristicas:</h3>
                        <p> <?php
                        foreach ($_SESSION['caracteristicas'] as $v) {

                            echo $v . "<br>";

                        }

                        ?> </p>
                    </div>

                    <div class="resumo">
                        <h3>Resumo:</h3>
                        <p> <?= $_SESSION['resumo'] ?> </p>
                    </div>
                </div>

                <?php
            }
            ?>
        </div>
    </div>

</body>

</html>