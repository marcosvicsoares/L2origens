<?php
require_once __DIR__ . '/../app/core/Env.php';
\App\Core\Env::load();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = $_POST['host'] ?? 'localhost';
    $db   = $_POST['db'] ?? 'l2jmega';
    $user = $_POST['user'] ?? 'root';
    $pass = $_POST['pass'] ?? '';

    $env = "DB_HOST={$host}\nDB_DATABASE={$db}\nDB_USERNAME={$user}\nDB_PASSWORD={$pass}\n";

    file_put_contents(__DIR__ . '/../.env', $env);

    echo "<p style='color:lightgreen;'>Arquivo .env criado com sucesso!</p>";
    echo "<a href='/'>Clique aqui para ir para o site</a>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Instalador - L2 Origens</title>
</head>
<body style="font-family: Arial; background: #111; color: #fff; padding: 20px;">
    <h1>Instalador do Site</h1>
    <form method="POST">
        <label>Host do Banco de Dados:</label><br>
        <input type="text" name="host" value="localhost"><br><br>

        <label>Nome do Banco de Dados:</label><br>
        <input type="text" name="db" value="l2jmega"><br><br>

        <label>Usuário do Banco de Dados:</label><br>
        <input type="text" name="user" value="root"><br><br>

        <label>Senha do Banco de Dados:</label><br>
        <input type="password" name="pass"><br><br>

        <button type="submit">Criar .env</button>
    </form>
</body>
</html>
