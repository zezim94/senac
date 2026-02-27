<?php

session_start();

if (!isset($_SESSION['logado']) || $_SESSION['logado'] != true) {
    session_unset();
    session_destroy();
    header('Location: index.php?acesso=invalido');
    exit;
}