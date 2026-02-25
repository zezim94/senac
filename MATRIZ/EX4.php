<?php

$matriz = [
    [1, 21],
    [5, 26],
    [9, 10],
    [3, 7],
    [6, 12],
    [8, 14],
];

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EX4 - Matriz 6x2</title>
    <style>
        body {
            font-family: Arial;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin-top: 50px;
        }

        h1 {
            margin-bottom: 30px;
        }

        p {
            font-size: 18px;
        }
    </style>
</head>

<body>

    <h1>Matriz 6x2</h1>

    <?php
    $maiorCinco = 0;
    for ($i = 0; $i < count($matriz); $i++) {
        for ($j = 0; $j < count($matriz[$i]); $j++) {
            echo $matriz[$i][$j] . "&nbsp;&nbsp;&nbsp;&nbsp;";
            if ($matriz[$i][$j] > 5) {
                $maiorCinco++;
            }
        }
        echo "<br>";
    }

    echo "<p>Quantidade de elementos maiores que 5: " . $maiorCinco . "</p>";
    ?>

</body>

</html>