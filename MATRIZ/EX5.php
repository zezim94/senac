
<?php

$matriz = [
    [1, 21, 36, 14, 30, 9],
    [5, 26, 17, 82, 12, 4],
    [9, 10, 11, 12, 16, 8],
    [1, 14, 15, 16, 20, 1]
];

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EX5 - Matriz 4x6</title>
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

    <h1>Matriz 4x6</h1>

    <?php
    $soma = 0;
    for ($i = 0; $i < count($matriz); $i++) {
        for ($j = 0; $j < count($matriz[$i]); $j++) {
            echo $matriz[$i][$j] . "&nbsp;&nbsp;&nbsp;&nbsp;";
            $soma += $matriz[$i][$j];
        }
        echo "<br>";

    }

    echo "<p>Soma de todos os elementos da matriz: " . $soma . "</p>";
    ?>

</body>

</html>