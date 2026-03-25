<?php
require_once 'DB/conexao.php';
require_once 'funcao/Usuario.php';

$pdo = conecta();
$id = $_POST['id'];

excluirUser($pdo, $id);

header('Location: usuario.php');

