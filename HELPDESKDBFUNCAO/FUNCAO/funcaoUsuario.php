<?php

function buscarPorId($conn, $id)
{
    $sql = 'SELECT * FROM user WHERE id = ?';
    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt)
        return false;

    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);

    $resul = mysqli_stmt_get_result($stmt);
    $usuario = mysqli_fetch_assoc($resul);

    mysqli_stmt_close($stmt);

    return $usuario;

}

function atualizarUsuario($conn, $id, $nome, $usuario, $email, $nivel, $senha = null)
{

    if (!empty($senha)) {

        // Atualiza com senha
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        $sql = "UPDATE user 
                SET nome = ?, usuario = ?, email = ?, senha = ?, nivel = ?
                WHERE id = ?";

        $stmt = mysqli_prepare($conn, $sql);

        if (!$stmt)
            return false;

        mysqli_stmt_bind_param(
            $stmt,
            "sssssi",
            $nome,
            $usuario,
            $email,
            $senhaHash,
            $nivel,
            $id
        );

    } else {

        // Atualiza sem mexer na senha
        $sql = "UPDATE user 
                SET nome = ?, usuario = ?, email = ?, nivel = ?
                WHERE id = ?";

        $stmt = mysqli_prepare($conn, $sql);

        if (!$stmt)
            return false;

        mysqli_stmt_bind_param(
            $stmt,
            "ssssi",
            $nome,
            $usuario,
            $email,
            $nivel,
            $id
        );
    }

    $resultado = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    return $resultado;
}

function deletarUsuario($conn, $id)
{
    $sql = 'DELETE FROM user WHERE id = ?';

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt)
        return false;

    mysqli_stmt_bind_param($stmt, 'i', $id);
    $resul = mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    return $resul;

}

function buscarUsuario($conn, $busca = null){
    $sql = '';
}