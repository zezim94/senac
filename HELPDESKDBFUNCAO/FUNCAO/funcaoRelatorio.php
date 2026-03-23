<?php

function relatorioAberto($conn)
{
    try {
        $sql = "SELECT COUNT(*) AS total FROM chamados WHERE status = 'aberto'";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] ?? 0;


    } catch (PDOException $e) {
        return $e;
    }
}

function relatorioAndamento($conn)
{
    try {
        $sql = "SELECT COUNT(*) AS total FROM chamados WHERE status = 'em andamento'";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] ?? 0;

    } catch (PDOException $e) {
        return $e;
    }
}
function relatorioConcluido($conn)
{
    try {
        $sql = "SELECT COUNT(*) AS total FROM chamados WHERE status = 'concluido'";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] ?? 0;

    } catch (PDOException $e) {
        return $e;
    }
}

