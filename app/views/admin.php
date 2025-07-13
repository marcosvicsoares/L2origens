<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Painel Administrativo - L2</title>
    <link rel="stylesheet" href="/assets/css/admin.css">
    <style>
        body { margin: 0; font-family: Arial, sans-serif; display: flex; }
        .sidebar { width: 200px; background: #111; color: #fff; height: 100vh; padding: 20px; }
        .sidebar a { color: #fff; text-decoration: none; display: block; margin: 10px 0; }
        .content { flex: 1; padding: 20px; background: #f5f5f5; }
        .header { background: #222; color: #fff; padding: 10px 20px; }
        .admin-stats .card { background: #fff; padding: 15px; margin-bottom: 10px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,.1); }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Admin L2</h2>
        <a href="/admin/dashboard">Dashboard</a>
        <a href="/admin/users">Contas</a>
        <a href="/admin/characters">Personagens</a>
        <a href="/admin/rewards">Recompensas</a>
        <a href="/admin/events">Eventos</a>
        <a href="/admin/logs">Logs</a>
        <a href="/logout">Sair</a>
    </div>

    <div class="content">
        <div class="header">
            <h1>Painel Administrativo</h1>
        </div>

        <div class="main">
            <?php if (isset($view)) include $view; ?>
        </div>
    </div>
</body>
</html>
