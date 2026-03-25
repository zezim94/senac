<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow" style="width: 350px;">
            <h3 class="text-center mb-3">Login</h3>

            <form action="processa_login.php" method="POST">
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Digite seu email">
                </div>

                <div class="mb-3">
                    <label class="form-label">Senha</label>
                    <input type="password" name="pass" class="form-control" placeholder="Digite sua senha">
                </div>

                <button type="submit" class="btn btn-primary w-100">Entrar</button>
            </form>

            <div class="text-center mt-3">
                <small>Não tem conta? <a href="cadastro.php">Cadastre-se</a></small>
            </div>
        </div>
    </div>

</body>

</html>