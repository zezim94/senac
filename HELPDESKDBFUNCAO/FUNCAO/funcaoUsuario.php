<?php

function buscarPorId($conn, $id)
{
    try {
        $stmt = $conn->prepare('SELECT * FROM user WHERE id = :id');
        $stmt->execute(['id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return false;
    }
}

function atualizarUsuario($conn, $id, $nome, $usuario, $email, $nivel, $senha = null)
{

    try {
        $stmt = $conn->prepare("SELECT * FROM user WHERE id = :id");
        $stmt->execute(['id' => $id]);

        $usuarioAtual = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$usuarioAtual)
            return false;

        $alterou =
            $usuarioAtual['nome'] !== $nome ||
            $usuarioAtual['usuario'] !== $usuario ||
            $usuarioAtual['email'] !== $email ||
            $usuarioAtual['nivel'] !== $nivel;

        if (!empty($senha)) {
            $alterou = true;
        }

        if (!$alterou) {
            return 'Nenhuma alteração';
        }

        if (!empty($senha)) {

            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

            $sql = "UPDATE user SET nome = :nome, usuario = :usuario, email = :email, senha = :senha, nivel = :nivel WHERE id = :id";

            $stmt = $conn->prepare($sql);

            return $stmt->execute([
                'nome' => $nome,
                'usuario' => $usuario,
                'email' => $email,
                'senha' => $senhaHash,
                'nivel' => $nivel,
                'id' => $id
            ]);

        } else {

            $sql = "UPDATE user SET nome = :nome, usuario = :usuario, email = :email, nivel = :nivel WHERE id = :id";

            $stmt = $conn->prepare($sql);

            return $stmt->execute([

                'nome' => $nome,
                'usuario' => $usuario,
                'email' => $email,
                'nivel' => $nivel,
                'id' => $id

            ]);

        }

    } catch (PDOException $e) {
        return false;
    }
}

function deletarUsuario($conn, $id)
{
    try {
        $sql = "DELETE FROM user WHERE id = :id";

        $stmt = $conn->prepare($sql);

        return $stmt->execute([
            'id' => $id
        ]);

    } catch (PDOException $e) {
        return false;
    }

}

function buscarUsuario($conn, $busca = null)
{
    try {
        if (!empty($busca)) {
            $sql = "SELECT * FROM user WHERE nome LIKE :nome OR email = :email";
            $stmt = $conn->prepare($sql);

            $stmt->execute([
                'nome' => "%" . $busca . "%",
                'email' => "%" . $busca . "%"
            ]);
        } else {
            $sql = "SELECT * FROM user";

            $stmt = $conn->prepare($sql);
            $stmt->execute();

        }

        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $usuarios;
    } catch (PDOException $e) {
        return false;
    }
}

function contarRegistros($conn, $tabela)
{
    try {
        // Prepara a query usando placeholder (evita SQL injection)
        $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM {$tabela}");
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Retorna total ou 0 se nada for encontrado
        return $row ? $row['total'] : 0;

    } catch (PDOException $e) {
        // Em caso de erro, retorna 0
        return 0;
    }
}

function aprovar($conn, $nivel, $id)
{


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        require_once '../conexao.php';
        $conn = conexao();

        $nivel = $_POST['nivel'];
        $id = $_POST['id'];

        $stmt = $conn->prepare("UPDATE user SET nivel = :nivel, status = 1 WHERE id = :id");

        return $stmt->execute([
            'nivel' => $nivel,
            'id' => $id
        ]);


    }
}