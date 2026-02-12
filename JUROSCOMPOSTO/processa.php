<?php

session_start();

function jurosMontante($dados)
{
    $capital = $_POST['capital1'];
    $taxa_juros = $_POST['taxa_juros1'];
    $prazo = $_POST['prazo1'];

    if ($capital <= 0 || $taxa_juros <= 0 || $prazo <= 0) {
        $_SESSION['error'] = "Todos os campos devem ser maiores que zero";
        header('Location: index.php');
        exit;
    }

    $montante = $capital * (1 + ($taxa_juros / 100)) ** $prazo;
    $juros = $montante - $capital;

    $_SESSION['capital1'] = $capital;
    $_SESSION['taxa_juros1'] = $taxa_juros;
    $_SESSION['prazo1'] = $prazo;

    $_SESSION['juros1'] = $juros;
    $_SESSION['montante1'] = $montante;

    header("Location: index.php");
    exit;
}

function capital($dados)
{
    $juros = $_POST['juros2'];
    $taxa_juros = $_POST['taxa_juros2'];
    $prazo = $_POST['prazo2'];

    if ($juros <= 0 || $taxa_juros <= 0 || $prazo <= 0) {
        $_SESSION['error'] = "Todos os campos devem ser maiores que zero";
        header('Location: index.php');
        exit;
    }

    $capital = $juros / ((1 + ($taxa_juros / 100)) ** $prazo - 1);


    $_SESSION['juros2'] = $juros;
    $_SESSION['taxa_juros2'] = $taxa_juros;
    $_SESSION['prazo2'] = $prazo;
    
    $_SESSION['capital2'] = $capital;
    
    header("Location: index.php");
    exit;
}

function taxaJuros($dados)
{
    $capital = $_POST['capital3'];
    $juros = $_POST['juros3'];
    $prazo = $_POST['prazo3'];

    $montante = $capital + $juros;
    $taxa_juros = ($juros / $capital) * 100;

    $_SESSION['capital3'] = $capital;
    $_SESSION['juros3'] = $juros;
    $_SESSION['prazo3'] = $prazo;

    $_SESSION['taxa_juros3'] = $taxa_juros;

    header("Location: index.php");
    exit;
}

function prazo($dados)
{
    $capital = $_POST['capital4'];
    $juros = $_POST['juros4'];
    $taxa_juros = $_POST['taxa_juros4'];

    if ($capital <= 0 || $juros <= 0 || $taxa_juros <= 0) {
        $_SESSION['error'] = "Todos os campos devem ser maiores que zero";
        header('Location: index.php');
        exit;
    }

    $montante = $capital + $juros;

    $prazo = log($montante / $capital) / log(1 + ($taxa_juros / 100));

    $_SESSION['capital4'] = $capital;
    $_SESSION['juros4'] = $juros;
    $_SESSION['taxa_juros4'] = $taxa_juros;
    $_SESSION['montante4'] = $montante;

    $_SESSION['prazo4'] = $prazo;

    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $operacao = $_POST['operacao'];

    switch ($operacao) {
        case 1:
            jurosMontante($_POST);
            break;

        case 2:
            capital($_POST);
            break;

        case 3:
            taxaJuros($_POST);
            break;

        case 4:
            prazo($_POST);
            break;

    }
} else {
    header("Location: index.php");
    exit;
}