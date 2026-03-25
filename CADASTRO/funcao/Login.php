<?php

function Login($pdo, $senha, $email)
{

    $stmt = $pdo->prepare("SELECT * FROM `user` WHERE email = :email");
    $stmt->execute(['email' => $email]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($senha, $user['senha'])) {
        return $user;
    }
    return false;

    return $user;
}