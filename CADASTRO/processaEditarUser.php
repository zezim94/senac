<?php

require_once 'DB/conexao.php';
require_once 'funcao/Usuario.php';

$pdo = conecta();
$id = $_POST['id'];
$nome = $_POST['nome'];
$email = $_POST['email'];


if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    atualizarUser($pdo, $nome, $email, $id);

    header('Location: usuario.php');
}