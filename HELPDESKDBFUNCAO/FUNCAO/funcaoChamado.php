<?php

function buscarPorIdChamados($conn, $id)
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
function buscarTodosChamados($conn, $busca)
{
    try {

        if (!empty($busca)) {
            $sql = 'SELECT c.*, u.nome as usuario FROM chamados c 
            LEFT JOIN user u ON c.userId = u.id
            WHERE c.titulo LIKE :titulo 
            OR c.categoria LIKE :categoria 
            OR c.status LIKE :status 
            OR u.nome LIKE :usuario';

            $stmt = $conn->prepare($sql);

            $stmt->execute([
                'titulo' => "%$busca%",
                'categoria' => "%$busca%",
                'status' => "%$busca%",
                'usuario' => "%$busca%"
            ]);

        } else {

            $sql = 'SELECT c.*, u.nome as usuario FROM chamados c 
            LEFT JOIN user u ON c.userId = u.id';

            $stmt = $conn->prepare($sql);
            $stmt->execute();
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        echo $e->getMessage(); // 👈 ativa isso pra debug
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