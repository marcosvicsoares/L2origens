<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle ?? 'Informações de Siege'); ?></title>
    <!-- Inclui o Tailwind CSS via CDN para estilização -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .castle-card {
            background-color: #ffffff;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            margin-bottom: 1rem;
        }
        .castle-card h3 {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 0.5rem;
        }
        .castle-card p {
            color: #555;
            margin-bottom: 0.25rem;
        }
        .status-alive {
            color: #22c55e; /* green-500 */
            font-weight: bold;
        }
        .status-dead {
            color: #ef4444; /* red-500 */
            font-weight: bold;
        }
    </style>
</head>
<body class="bg-gray-100 p-4">
    <div class="container mx-auto max-w-4xl">
        <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Informações de Cerco (Siege)</h2>

        <?php if (isset($successMessage) && $successMessage): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Sucesso!</strong>
                <span class="block sm:inline"><?php echo htmlspecialchars($successMessage); ?></span>
            </div>
        <?php endif; ?>

        <?php if (isset($errorMessage) && $errorMessage): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Erro!</strong>
                <span class="block sm:inline"><?php echo htmlspecialchars($errorMessage); ?></span>
            </div>
        <?php endif; ?>

        <?php if (!empty($castelos)): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <?php foreach ($castelos as $castle): ?>
                    <div class="castle-card">
                        <h3><?php echo htmlspecialchars($castle['name']); ?></h3>
                        <p>Proprietário:
                            <?php if (!empty($castle['clan_name'])): ?>
                                <span class="font-semibold"><?php echo htmlspecialchars($castle['clan_name']); ?></span>
                            <?php else: ?>
                                <span class="text-gray-500">NPC (Sem Clã)</span>
                            <?php endif; ?>
                        </p>
                        <p>Próxima Siege:
                            <?php if (!empty($castle['siege_date'])): ?>
                                <span class="font-semibold"><?php echo htmlspecialchars($castle['siege_date']); ?></span>
                            <?php else: ?>
                                <span class="text-gray-500">A definir</span>
                            <?php endif; ?>
                        </p>
                        <!-- Adicione mais informações do castelo aqui, se disponíveis -->
                        <div class="mt-4 text-right">
                            <a href="/sieges/register" class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-md text-sm transition duration-200">
                                Registrar para Siege
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative text-center" role="alert">
                <strong class="font-bold">Nenhum castelo encontrado.</strong>
                <span class="block sm:inline">Não há informações de castelos disponíveis no momento.</span>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
