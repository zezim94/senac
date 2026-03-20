<?php

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