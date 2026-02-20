<?php

session_start();

if (!isset($_SESSION['vitoria'])) {

    $_SESSION['vitoria'] = 0;
    $_SESSION['empate'] = 0;
    $_SESSION['derrota'] = 0;
}

function jokenpo($jogada)
{

    $opcoes = ['pedra', 'papel', 'tesoura'];

    $pc = $opcoes[array_rand($opcoes)];
    $eu = $jogada;

    $resultado = '';

    if ($eu == $pc) {
        $resultado = 'Empate';
        $_SESSION['empate']++;
    } elseif (($eu == 'pedra' && $pc == 'tesoura') || ($eu == 'tesoura' && $pc == 'papel') || ($eu == 'papel' && $pc == 'pedra')) {
        $resultado = 'Vitoria';
        $_SESSION['vitoria']++;
    } else {
        $resultado = 'Derrota';
        $_SESSION['derrota']++;
    }

    $_SESSION['aproveitamento'] = $_SESSION['vitoria'] / ($_SESSION['vitoria'] + $_SESSION['empate'] + $_SESSION['derrota']) * 100;
    $_SESSION['resultado'] = $resultado;

}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    jokenpo($_POST['jogada']);
    header("Location: index.php");
    exit;
} else {
    header("Location: index.php");
    exit;
}