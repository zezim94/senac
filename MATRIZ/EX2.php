<?php

$matriz = [
    [1, 21, 3],
    [5, 26, 17],
    [9, 10, 11]
];

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EX2 - Matriz 3x3</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 50px;
        }

        h1 {
            margin-bottom: 30px;
        }

        p {
            font-size: 18px;
            border-bottom: 3px solid black;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <h1>Matriz 3x3</h1>

    <?php
    for ($i = 0; $i < count($matriz); $i++) {
        $somaLinha = 0;
        for ($j = 0; $j < count($matriz[$i]); $j++) {
            echo $matriz[$i][$j] . "&nbsp;&nbsp;&nbsp;&nbsp;";
            $somaLinha += $matriz[$i][$j];
        }
        echo "<br>";

        echo "<p>Linha " . ($i + 1) . " Soma: " . $somaLinha . "</p>";
      
    }
    ?>

</body>

</html>