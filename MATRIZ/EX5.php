
<?php

$matriz = [
    [1, 21, 3, 14, 30, 9],
    [5, 26, 17, 8, 12, 4],
    [9, 10, 11, 12, 16, 8],
    [13, 14, 15, 16, 20, 12]
];

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <h1>Matriz</h1>

    <?php
    $soma = 0;
    for ($i = 0; $i < count($matriz); $i++) {          // percorre linhas
        for ($j = 0; $j < count($matriz[$i]); $j++) {  // percorre colunas
            echo $matriz[$i][$j] . "&nbsp;&nbsp;&nbsp;&nbsp;";
            $soma += $matriz[$i][$j];
        }
        echo "<br>";

    }

    echo "Soma de todos os elementos da matriz: " . $soma . "<br>";
    ?>

</body>

</html>