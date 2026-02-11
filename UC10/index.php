<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Cinema</title>
</head>

<body>
    <div class="container">


        <h1>Avatar: Fogo e Cinzas</h1>

        <?php
        if (isset($_SESSION['aviso'])) { ?>
            <p class="aviso"> <?= $_SESSION['aviso'] ?></p>
            <?php unset(
                $_SESSION['aviso']

            ) ?>
            <?php
        }
        ?>

        <form action="processa.php" method="POST">

            <div class="group">
                <label for="name">Nome:</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="group">
                <label for="idade">Idade:</label>
                <input type="number" id="idade" name="idade" required>
            </div>

            <div class="group" id="sexo">
                <label>Sexo:</label>
                <div class="sexoValue">
                    <input type="radio" id="sexom" name="sexo" value="Masculino" checked>
                    <label for="sexom">Masculino</label>
                    <input type="radio" id="sexof" name="sexo" value="Feminino">
                    <label for="sexof">Feminino</label>
                </div>
            </div>

            <div class="group">
                <label for="nota">O que você achou do filme?</label>
                <select name="nota">
                    <option value="excelente">Excelente</option>
                    <option value="bom">Bom</option>
                    <option value="regular">Regular</option>
                    <option value="pessimo">Péssimo</option>
                </select>
            </div>

            <div class="butons">
                <input type="submit" value="Enviar">
                <a href="limpar.php">Limpar</a>
            </div>
        </form>

        <div class="resultado">

            <?php

            if (isset($_SESSION['media_idade'])) {
                ?>
                <h2>Resultado</h2>

                <h3>Total de pessoas:</h3>
                <p> <?= $_SESSION['total_pessoas'] ?> </p>
                <hr>
                <h3>Homens:</h3>
                <p> <?= number_format($_SESSION['mas'], 2) . "%" ?> </p>
                <h3>Mulheres: </h3>
                <p> <?= number_format($_SESSION['fem'], 2) . "%" ?> </p>
                <hr>
                <h3>Excelente: </h3>
                <p> <?= number_format($_SESSION['excelente'], 2) . "%" ?> </p>
                <h3>Bom: </h3>
                <p> <?= number_format($_SESSION['bom'], 2) . "%" ?> </p>
                <h3>Regular: </h3>
                <p> <?= number_format($_SESSION['regular'], 2) . "%" ?> </p>
                <h3>Péssimo: </h3>
                <p> <?= number_format($_SESSION['pessimo'], 2) . "%" ?> </p>
                <hr>
                <h3>Média de idade:</h3>
                <p> <?= number_format($_SESSION['media_idade'], 2) ?></p>

                <?php
            }
            ?>

            <h2 class="detalhesB">Detalhes</h2>

        </div>
    </div>

    <div class="detalhes hidden">
        <div class="close">X</div>

        <?php

        foreach ($_SESSION['dados'] as $pessoas) {
            echo "<p class='pessoas'>" . $pessoas['nome'] . " ( " . $pessoas['idade'] . " - " . $pessoas['sexo'] . " - " . $pessoas['nota'] . " )</p>";
        }

        ?>
    </div>

    <script>

        const aviso = document.querySelector('.aviso')

        if (aviso) {
            setTimeout(() => {
                aviso.remove()
            }, 2500);
        }

        const resultado = document.querySelector('.resultado')
        const pessoas = <?= $_SESSION['total_pessoas'] ?? 0; ?>;

        if (pessoas > 0) {
            resultado.style.display = 'block'
        } else {
            resultado.style.display = 'none'
        }

        const detalhesB = document.querySelector('.detalhesB');
        const detalhes = document.querySelector('.detalhes');
        const container = document.querySelector('.container');
        const close = document.querySelector('.close');

        detalhesB.addEventListener('click', () => {
            detalhes.classList.toggle('hidden');
            detalhesB.classList.toggle('hidden');
            container.classList.toggle('opacity');
        });

        close.addEventListener('click', () => {
            detalhes.classList.toggle('hidden');
            container.classList.toggle('opacity');
            detalhesB.classList.toggle('hidden');
        });

    </script>

</body>

</html>