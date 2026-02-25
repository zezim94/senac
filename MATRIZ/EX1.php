<?php

$matriz = [
    [1, 21, 3, 14],
    [5, 26, 17, 8],
    [9, 10, 11, 12],
    [13, 14, 15, 16]
];

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>EX1 - Matriz 4x4</title>

    <style>
        *{
            margin: 0;
            padding: 0;
        }
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 50px;
        }

        h1{
            margin-bottom: 30px;
        }

        table {
            border-collapse: collapse;
        }

        td {
            border: 2px solid black;
            width: 60px;
            height: 60px;
            text-align: center;
            font-size: 18px;         
            font-weight: bold;
            background-color: #3465ecff;
            color: #ffffff;
        }
    </style>
</head>

<body>

    <h1>Matriz 4x4</h1>

    <table>

        <?php
        for ($i = 0; $i < 4; $i++) {
            echo "<tr>";
        
            for ($j = 0; $j < 4; $j++) {
                echo "<td>" . $matriz[$i][$j] . "</td>";
            }

            echo "</tr>";
        }
        ?>

    </table>

</body>

</html>