<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!isset($_SESSION['dados'])) {
        $_SESSION['dados'] = [];
    }

    $name = $_POST["name"];
    $idade = $_POST["idade"];
    $sexo = $_POST["sexo"];
    $nota = $_POST["nota"];



    foreach ($_SESSION['dados'] as $dado) {
        if (strtolower($dado['nome']) == strtolower($name)) {
            $_SESSION['aviso'] = $name . " já preencheu o formulário.";
            header("Location: index.php");
            exit;
        }
    }

    $_SESSION['dados'][] = [
        'nome' => $name,
        'idade' => $idade,
        'sexo' => $sexo,
        'nota' => $nota
    ];

    $total_pessoas = count($_SESSION['dados']);
    $total_idade = 0;
    $total_homens = 0;
    $total_mulheres = 0;
    $total_excelentes = 0;
    $total_bons = 0;
    $total_regulares = 0;
    $total_pesimos = 0;

    foreach ($_SESSION['dados'] as $dado) {


        $total_idade += $dado['idade'];


        if ($dado['sexo'] == "Masculino") {
            $total_homens++;
        } else {
            $total_mulheres++;
        }

        switch ($dado['nota']) {
            case "excelente":
                $total_excelentes++;
                break;
            case "bom":
                $total_bons++;
                break;
            case "regular":
                $total_regulares++;
                break;
            case "pessimo":
                $total_pesimos++;
                break;
        }

    }

    if ($total_pessoas > 0) {

        $_SESSION['total_pessoas'] = $total_pessoas;
        $_SESSION['media_idade'] = $total_idade / $total_pessoas;

        $_SESSION['mas'] = $total_homens / $total_pessoas * 100;
        $_SESSION['fem'] = $total_mulheres / $total_pessoas * 100;

        $_SESSION['excelente'] = $total_excelentes / $total_pessoas * 100;
        $_SESSION['bom'] = $total_bons / $total_pessoas * 100;
        $_SESSION['regular'] = $total_regulares / $total_pessoas * 100;
        $_SESSION['pessimo'] = $total_pesimos / $total_pessoas * 100;

    }

    header("Location: index.php");
} else {
    header("Location: index.php");
}