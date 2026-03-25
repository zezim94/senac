<?php

function cadastroUser($pdo, $nome, $email, $senha)
{

    $stmt = $pdo->prepare("INSERT INTO `user`(nome, email, senha) VALUES(:nome, :email, :senha)");
    return $stmt->execute([
        'nome' => $nome,
        'email' => $email,
        'senha' => $senha
    ]);
}

function listarUser($pdo)
{
    $stmt = $pdo->prepare("SELECT * FROM `user`");
    $stmt->execute();

    $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $user;
}

function atualizarUser($pdo, $nome, $email, $id)
{
    $stmt = $pdo->prepare("UPDATE `user` SET nome = :nome, email = :email WHERE id = :id");

    $res = $stmt->execute([
        'nome' => $nome,
        'email' => $email,
        'id' => $id
    ]);


    if (!$res) {
        return false;
    }

}

function bucarUserPorId($pdo, $id)
{
    $stmt = $pdo->prepare("SELECT * FROM `user` WHERE id = :id");
    $stmt->execute([
        'id' => $id
    ]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    return $user;
}
