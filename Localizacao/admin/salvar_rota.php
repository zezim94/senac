<?php

include "../config/conexao.php";

$nome = $_POST['nome'];
$descricao = $_POST['descricao'];

$sql = "INSERT INTO rotas
(nome_rota,descricao)
VALUES
('$nome','$descricao')";

$conn->query($sql);

header("Location: rotas.php");