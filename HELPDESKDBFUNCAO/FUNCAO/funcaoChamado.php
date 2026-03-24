<?php

function buscarPorId($conn, $id)
{
    $id = (int) $id;

    $sql = "SELECT c.*, u.nome as usuario
            FROM chamados c
            LEFT JOIN user u ON c.userId = u.id
            WHERE c.id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}
function buscarTodos($conn, $busca)
{
    try {

        if (!empty($busca)) {
            $sql = 'SELECT c.*, u.nome as usuario FROM chamados c 
            LEFT JOIN user u  ON c.userId = u.id
            WHERE titulo LIKE :titulo OR categoria LIKE :categoria OR status LIKE :status OR usuario LIKE :usuario';


            $stmt = $conn->prepare($sql);

            $stmt->execute([
                'titulo' => "%$busca%",
                'categoria' => "%$busca%",
                'status' => "%$busca%",
                'usuario' => "%$busca%"
            ]);
        } else {
            $sql = 'SELECT c.*, u.nome as usuario FROM chamados c 
            LEFT JOIN user u  ON c.userId = u.id';

            $stmt = $conn->prepare($sql);
            $stmt->execute();
        }

        $chamados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $chamados;

    } catch (PDOException $e) {
        return false;
    }
}

function criar($conn, $titulo, $categoria, $descricao, $idUser)
{
    $sql = 'INSERT INTO chamados(titulo, categoria, descricao, userId) values(:titulo, :categoria, :descricao, :userId)';

    $stmt = $conn->prepare($sql);

    return $stmt->execute([
        'titulo' => $titulo,
        'categoria' => $categoria,
        'descricao' => $descricao,
        'userId' => $idUser
    ]);

}

function update($conn, $titulo, $categoria, $descricao, $observacao, $status, $preco, $id)
{
    $sql = 'UPDATE chamados set titulo = :titulo, categoria = :categoria, descricao = :descricao, statusTec = :statusTec, status = :status, preco = :preco WHERE id = :id';


    $stmt = $conn->prepare($sql);

    return $stmt->execute([
        'titulo' => $titulo,
        'categoria' => $categoria,
        'descricao' => $descricao,
        'statusTec' => $observacao,
        'status' => $status,
        'preco' => $preco,
        'id' => $id
    ]);
}

function delete($conn, $id)
{
    $sql = 'DELETE FROM chamados WHERE id = :id';

    $stmt = $conn->prepare($sql);

    return $stmt->execute([
        'id' => $id
    ]);
}