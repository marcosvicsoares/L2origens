<?php
// install_env.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = $_POST['DB_HOST'];
    $user = $_POST['DB_USER'];
    $pass = $_POST['DB_PASS'];
    $name = $_POST['DB_NAME'];

    $envContent = "DB_HOST={$host}
DB_USER={$user}
DB_PASS={$pass}
DB_NAME={$name}
";

    file_put_contents(__DIR__ . '/.env', $envContent);
    echo "Arquivo .env criado com sucesso!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head><meta charset="UTF-8"><title>Instalador .env</title></head>
<body style="font-family:Arial; background:#111; color:#fff; padding:30px;">
    <h1>Configurar Banco de Dados</h1>
    <form method="POST">
        <label>Host: <input name="DB_HOST" value="localhost"></label><br><br>
        <label>Usuário: <input name="DB_USER" value="root"></label><br><br>
        <label>Senha: <input name="DB_PASS" type="password"></label><br><br>
        <label>Database: <input name="DB_NAME" value="l2jmega"></label><br><br>
        <button type="submit">Gerar .env</button>
    </form>
</body>
</html>
