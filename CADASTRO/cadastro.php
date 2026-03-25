<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow" style="width: 400px;">
            <h3 class="text-center mb-3">Cadastro</h3>

            <form action="processa_cadastro.php" method="POST">
                <div class="mb-3">
                    <label class="form-label">Nome</label>
                    <input type="text" name="nome" class="form-control" placeholder="Seu nome">
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Seu email">
                </div>

                <div class="mb-3">
                    <label class="form-label">Senha</label>
                    <input type="password" name="pass" class="form-control" placeholder="Crie uma senha">
                </div>

                <div class="mb-3">
                    <label class="form-label">Confirmar Senha</label>
                    <input type="password" name="confirmPass" class="form-control" placeholder="Confirme a senha">
                </div>

                <button type="submit" class="btn btn-success w-100">Cadastrar</button>
            </form>

            <div class="text-center mt-3">
                <small>Já tem conta? <a href="login.php">Fazer login</a></small>
            </div>
        </div>
    </div>

</body>

</html>