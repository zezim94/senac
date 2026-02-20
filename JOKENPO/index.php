<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>JoKenPo</title>
</head>

<body>

    <h1>JoKenPo</h1>

    <form action="jogo.php" method="POST">

        <button type="submit" name="jogada" value="pedra"><img src="img/pedra.png" alt="pedra"></button>
        <button type="submit" name="jogada" value="papel"><img src="img/papel.png" alt="papel"></button>
        <button type="submit" name="jogada" value="tesoura"><img src="img/tesoura.png" alt="tesoura"></button>

    </form>

    <div class="resultado">

        <?php

        if (isset($_SESSION['resultado'])) {
            switch ($_SESSION['resultado']) {
                case 'Empate':
                    echo "<p style='color: green;'><img src='img/empate.png' alt='empate'></p>";
                    break;
                case 'Vitoria':
                    echo "<p style='color: green;'><img src='img/vitoria.png' alt='vitoria'></p>";
                    break;
                case 'Derrota':
                    echo "<p style='color: red;'><img src='img/derrota.png' alt=''></p>";
                    break;
            }
        }

        ?>
    </div>

    <div class="placar">
        <p>Vitoria: <?php echo $_SESSION['vitoria'] ?? 0; ?></p>
        <p class="derrota">Derrota: <?php echo $_SESSION['derrota'] ?? 0; ?></p>
        <p>Empate: <?php echo $_SESSION['empate'] ?? 0; ?></p>
        <p>Aproveitamento:
            <?php echo isset($_SESSION['aproveitamento']) ? number_format($_SESSION['aproveitamento'], 2) : '0'; ?>%
        </p>
    </div>

    <div class="reiniciar hidden">
        <img src="img/feliz.png" alt="cara feliz" class="hidden">
        <img src="img/triste.png" alt="cara triste" class="hidden">
        <a href="limpar.php">Reiniciar</a>
    </div>

    <script>
        let vitoria = <?php echo $_SESSION['vitoria']; ?>;
        let derrota = <?php echo $_SESSION['derrota']; ?>;
        let empate = <?php echo $_SESSION['empate']; ?>;

        if (vitoria >= 10 || derrota >= 10) {

            const reiniciar = document.querySelector('.reiniciar');
            reiniciar.classList.remove('hidden');

            const form = document.querySelector('form');
            form.style.display = 'none';

            const resultado = document.querySelector('.resultado');
            resultado.style.display = 'none';

            const h1 = document.querySelector('h1');
            h1.innerText = 'Fim do jogo';

            const carinha = document.querySelectorAll('.reiniciar img');

            if (vitoria >= 10) {
                carinha[0].classList.remove('hidden');
            } else {
                carinha[1].classList.remove('hidden');
            }

        }

        const resultado = document.querySelector('.resultado');

        setTimeout(() => {
            resultado.remove();
        }, 2500);

    </script>
</body>

</html>