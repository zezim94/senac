<?php
include '../verificaLogin.php';
include '../conexao.php';
include '../FUNCAO/funcaoUsuario.php';



$conn = conexao();

if($_SERVER['REQUEST_METHOD'] == 'POST')
{

$idUser = $_POST['id'];
$nome = $_POST['nome'];
$usuario = $_POST['usuario'];
$email = $_POST['email'];
$senha = $_POST['senha'] ?? '';
$nivel = $_POST['nivel'];

atualizarUsuario($conn, $idUser, $nome, $usuario, $email, $nivel);

header('Location: usuarios.php');
    
}


?>