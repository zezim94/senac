<?php

session_start();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Juros Compostos</title>
</head>

<body>

    <div class="container">

        <h1>Calculadora de Juros Compostos</h1>

        <div class="escolha">
            <button>1 - Valor Juros e Montante</button>
            <button>2 - Valor do Capital</button>
            <button>3 - Valor da Taxa de Juros</button>
            <button>4 - Valor do Prazo</button>
        </div>

        <?php
        if (isset($_SESSION['error'])) {
            echo "<div class='error'>" . $_SESSION['error'] . "</div>";
            unset($_SESSION['error']);
        }
        ?>

        <div class="box hidden">

            <h2>1 - Valor Juros e Montante</h2>
            <form action="processa.php" method="POST">
                <input type="hidden" name="operacao" value="1">
                <label for="capital1">Capital:</label>
                <input type="number" name="capital1" id="capital1"
                    value="<?php echo isset($_SESSION['capital1']) ? $_SESSION['capital1'] : ''; ?>">
                <label for="taxa_juros1">Taxa de Juros:</label>
                <input type="number" name="taxa_juros1" id="taxa_juros1"
                    value="<?php echo isset($_SESSION['taxa_juros1']) ? $_SESSION['taxa_juros1'] : ''; ?>">
                <label for="prazo1">Prazo:</label>
                <input type="number" name="prazo1" id="prazo1"
                    value="<?php echo isset($_SESSION['prazo1']) ? $_SESSION['prazo1'] : ''; ?>">
                <input type="submit" value="Calcular">
            </form>

            <div class="resultado">
                <?php
                if (isset($_SESSION['juros1'])) {
                    echo "<p>Juros: R$ " . number_format($_SESSION['juros1'], 2, ',', '.') . "<br></p>";
                    echo "<p>Montante: R$ " . number_format($_SESSION['montante1'], 2, ',', '.') . "<br></p>";
                }
                ?>
            </div>

        </div>

        <div class="box hidden">
            <h2>2 - Valor do Capital</h2>
            <form action="processa.php" method="POST">
                <input type="hidden" name="operacao" value="2">
                <label for="juros2">Juros</label>
                <input type="number" name="juros2" id="juros2"
                    value="<?php echo isset($_SESSION['juros2']) ? $_SESSION['juros2'] : ''; ?>">
                <label for="taxa_juros2">Taxa de Juros</label>
                <input type="number" name="taxa_juros2" id="taxa_juros2"
                    value="<?php echo isset($_SESSION['taxa_juros2']) ? $_SESSION['taxa_juros2'] : ''; ?>">
                <label for="prazo2">Prazo</label>
                <input type="number" name="prazo2" id="prazo2"
                    value="<?php echo isset($_SESSION['prazo2']) ? $_SESSION['prazo2'] : ''; ?>">
                <input type="submit" value="Calcular">
            </form>

            <div class="resultado">
                <?php
                if (isset($_SESSION['capital2'])) {
                    echo "Capital: R$ " . number_format($_SESSION['capital2'], 2, ',', '.') . "<br>";
                }
                ?>
            </div>
        </div>

        <div class="box hidden">
            <h2>3 - Valor da Taxa de Juros</h2>
            <form action="processa.php" method="POST">
                <input type="hidden" name="operacao" value="3">
                <label for="capital3">Capital</label>
                <input type="number" name="capital3" step="0.01" id="capital3"
                    value="<?php echo isset($_SESSION['capital3']) ? $_SESSION['capital3'] : ''; ?>">
                <label for="juros3">Juros</label>
                <input type="number" name="juros3" step="0.01" id="juros3"
                    value="<?php echo isset($_SESSION['juros3']) ? $_SESSION['juros3'] : ''; ?>">
                <label for="prazo3">Prazo</label>
                <input type="number" name="prazo3" step="0.01" id="prazo3"
                    value="<?php echo isset($_SESSION['prazo3']) ? $_SESSION['prazo3'] : ''; ?>">
                <input type="submit" value="Calcular">
            </form>

            <div class="resultado">
                <?php
                if (isset($_SESSION['taxa_juros3'])) {
                    echo "Taxa de Juros: " . number_format($_SESSION['taxa_juros3'], 2, ',', '.') . "%";
                }
                ?>
            </div>
        </div>

        <div class="box hidden">
            <h2>4 - Valor do Prazo</h2>
            <form action="processa.php" method="POST">
                <input type="hidden" name="operacao" value="4">
                <label for="capital4">Capital</label>
                <input type="number" name="capital4" id="capital4"
                    value="<?php echo isset($_SESSION['capital4']) ? $_SESSION['capital4'] : ''; ?>">
                <label for="juros4">Juros</label>
                <input type="number" name="juros4" id="juros4"
                    value="<?php echo isset($_SESSION['juros4']) ? $_SESSION['juros4'] : ''; ?>">
                <label for="taxa_juros4">Taxa de Juros</label>
                <input type="number" name="taxa_juros4" id="taxa_juros4"
                    value="<?php echo isset($_SESSION['taxa_juros4']) ? $_SESSION['taxa_juros4'] : ''; ?>">
                <input type="submit" value="Calcular">
            </form>

            <div class="resultado">
                <?php
                if (isset($_SESSION['prazo4'])) {
                    echo "Prazo: " . number_format($_SESSION['prazo4'], 2, ',', '.') . " meses";
                }
                ?>
            </div>
        </div>
    </div>

    <script>
        const botoes = document.querySelectorAll('button');
        const boxes = document.querySelectorAll('.box');

        const enviar = document.querySelectorAll('input[type="submit"]');

        window.addEventListener('load', () => {
            const boxAtiva = sessionStorage.getItem('boxAtiva');

            if (boxAtiva !== null) {
                boxes.forEach((box) => {
                    box.classList.add('hidden');
                });

                boxes[boxAtiva].classList.remove('hidden');
            }
        });

        botoes.forEach((botao, index) => {
            botao.addEventListener('click', () => {
                boxes.forEach((box) => {
                    box.classList.add('hidden');
                });
                boxes[index].classList.remove('hidden');
                sessionStorage.setItem('boxAtiva', index);
            });
        });
    </script>
</body>

</html>