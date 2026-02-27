<?php

$server = "localhost";
$user = "root";
$pass = '';
$db = "helpdesk";

$conn = mysqli_connect($server, $user, $pass, $db);

if($conn){
   // die("Conectado com sucesso");
//    // Dados do usuário
// $nome = "Andelson";
// $email = "andelsonascimento@gmail.com";
// $senha = "123456";
// $usuario = 'andelson94';
// $nivel = 'admin';

// // Gerando hash seguro da senha
// $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

// // Usando prepared statement (MUITO IMPORTANTE)
// $sql = "INSERT INTO user (nome, usuario, email, senha, nivel) VALUES (?, ?, ?, ?, ?)";
// $stmt = mysqli_prepare($conn, $sql);

// mysqli_stmt_bind_param($stmt, "sssss", $nome, $usuario, $email, $senhaHash, $nivel);

// if (mysqli_stmt_execute($stmt)) {
//     echo "Usuário cadastrado com sucesso!";
// } else {
//     echo "Erro ao cadastrar: " . mysqli_error($conn);
// }
}else{
    die("Error: " . mysqli_connect_error());
}