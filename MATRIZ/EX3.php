<?php

$matriz = [
    [10, 21, 3],
    [12, 26, 17],
    [60, 10, 11],
    [13, 14, 15],
    [50, 18, 20],
];

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EX3 - Matriz 5x3</title>
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

    <h1>Matriz 5x3</h1>

    <?php
    $soma = 0;
    $totalElementos = 0;
    for ($i = 0; $i < count($matriz); $i++) {
        for ($j = 0; $j < count($matriz[$i]); $j++) {
            echo $matriz[$i][$j] . "&nbsp;&nbsp;&nbsp;&nbsp;";
            $soma += $matriz[$i][$j];
            $totalElementos++;
        }
        echo "<br>";
    }


    echo "<p>Media de todos os elementos da matriz: " . number_format($soma / $totalElementos, 2) . "</p>";
    ?>

</body>

</html>