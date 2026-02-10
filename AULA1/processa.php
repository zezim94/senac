<?php
session_start();

if (!empty($_POST['name'])) {


    $peso = $_POST['peso'];
    $altura = $_POST['altura'];

    $imc = $peso / ($altura * $altura);

    $class = '';

    if ($imc < 18.5) {
        $class = "Abaixo do peso";
    } elseif ($imc < 24.9) {
        $class = "Peso normal";
    } elseif ($imc < 29.9) {
        $class = "Sobrepeso";
    } else {
        $class = "Obesidade";
    }

    $_SESSION['resultado'] = $imc;
    $_SESSION['class'] = $class;
    $_SESSION['dados'] = $_POST;
    unset($_SESSION['erro']);



    header('Location: index.php');
    exit;
} else {
    $_SESSION['erro'] = "Preencha os dados !";
    header('Location: index.php');
}
