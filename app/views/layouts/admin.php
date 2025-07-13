<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'Painel Administrativo'; ?></title>
    <!-- Inclua o Tailwind CSS (ou seu CSS personalizado) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
        }
        .sidebar {
            width: 250px;
            background-color: #2d3748; /* bg-gray-800 */
            color: #e2e8f0; /* text-gray-200 */
            min-height: 100vh;
        }
        .sidebar a {
            padding: 1rem 1.5rem;
            display: block;
            color: #e2e8f0;
            transition: background-color 0.2s;
        }
        .sidebar a:hover {
            background-color: #4a5568; /* bg-gray-700 */
        }
        .sidebar a.active {
            background-color: #4299e1; /* bg-blue-500 */
            font-weight: bold;
        }
        .content-area {
            flex-grow: 1;
            padding: 1.5rem;
        }
    </style>
</head>
<body class="flex">
    <!-- Sidebar -->
    <aside class="sidebar shadow-lg">
        <div class="p-6 text-xl font-bold text-white border-b border-gray-700">
            Admin Panel
        </div>
        <nav class="mt-5">
            <a href="/admin" class="<?php echo (strpos($_SERVER['REQUEST_URI'], '/admin') === 0 && $_SERVER['REQUEST_URI'] === '/admin') ? 'active' : ''; ?>">Dashboard</a>
            <a href="/admin/votos" class="<?php echo (strpos($_SERVER['REQUEST_URI'], '/admin/votos') === 0) ? 'active' : ''; ?>">Votos</a>
            <a href="/admin/rewards" class="<?php echo (strpos($_SERVER['REQUEST_URI'], '/admin/rewards') === 0) ? 'active' : ''; ?>">Recompensas</a>
            <a href="/admin/events" class="<?php echo (strpos($_SERVER['REQUEST_URI'], '/admin/events') === 0) ? 'active' : ''; ?>">Eventos</a>
            <a href="/admin/logs" class="<?php echo (strpos($_SERVER['REQUEST_URI'], '/admin/logs') === 0) ? 'active' : ''; ?>">Logs</a>
            <a href="/admin/battlepass" class="<?php echo (strpos($_SERVER['REQUEST_URI'], '/admin/battlepass') === 0) ? 'active' : ''; ?>">Battle Pass</a>
            <a href="/admin/roleta" class="<?php echo (strpos($_SERVER['REQUEST_URI'], '/admin/roleta') === 0) ? 'active' : ''; ?>">Roleta</a>
            <a href="/admin/sieges" class="<?php echo (strpos($_SERVER['REQUEST_URI'], '/admin/sieges') === 0) ? 'active' : ''; ?>">Gerenciar Sieges</a>
            <a href="/admin/loja" class="<?php echo (strpos($_SERVER['REQUEST_URI'], '/admin/loja') === 0) ? 'active' : ''; ?>">Gerenciar Loja</a>
            <a href="/logout" class="text-red-400 hover:bg-red-700 hover:text-white">Sair</a>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="content-area">
        <header class="bg-white shadow-md p-4 rounded-lg mb-6 flex justify-between items-center">
            <h1 class="text-3xl font-semibold text-gray-800"><?php echo $pageTitle ?? 'Bem-vindo ao Painel!'; ?></h1>
            <!-- Você pode adicionar informações do usuário logado aqui -->
            <div class="text-gray-600">Olá, Admin!</div>
        </header>

        <main>
            <?php
            // $content é a variável que contém o conteúdo da view específica
            if (isset($content)) {
                echo $content;
            }
            ?>
        </main>

        <footer class="mt-8 text-center text-gray-500 text-sm">
            &copy; <?php echo date('Y'); ?> Seu Projeto. Todos os direitos reservados.
        </footer>
    </div>
</body>
</html>
