<?php

function relatorioAberto($conn)
{
    try {
        $sql = "SELECT COUNT(*) AS total FROM chamados WHERE status = 'aberto'";

        $stmt = $conn->prepare($sql);

    } catch (\Throwable $th) {
        //throw $th;
    }
}