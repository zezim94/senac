
<?php

$matriz = [
    [1, 21, 3],
    [5, 26, 17],
    [9, 10, 11],
    [13, 14, 15],
    [50, 18, 20],
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
    $totalElementos = 0;
    for ($i = 0; $i < count($matriz); $i++) {          // percorre linhas
        for ($j = 0; $j < count($matriz[$i]); $j++) {  // percorre colunas
            echo $matriz[$i][$j] . "&nbsp;&nbsp;&nbsp;&nbsp;";
            $soma += $matriz[$i][$j];
            $totalElementos++;
        }
        echo "<br>";
    }


    echo "Media de todos os elementos da matriz: " . $soma / $totalElementos . "<br>";
    ?>

</body>

</html>
