<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle ?? 'Registro de Siege'); ?></title>
    <!-- Inclui o Tailwind CSS via CDN para estilização -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full">
        <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Registrar para Siege</h2>

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

        <?php if (isset($userClan) && $userClan): ?>
            <div class="mb-4 p-4 bg-blue-50 rounded-md border border-blue-200 text-blue-800">
                <p class="font-semibold">Seu Clã:</p>
                <p>Nome: <?php echo htmlspecialchars($userClan['clan_name']); ?></p>
                <p>Nível: <?php echo htmlspecialchars($userClan['clan_level'] ?? 'N/A'); ?></p>
                <p>ID do Clã: <?php echo htmlspecialchars($userClan['clan_id']); ?></p>
            </div>

            <form action="/siege/register" method="POST">
                <!-- Campo oculto para o ID do clã -->
                <input type="hidden" name="clan_id" value="<?php echo htmlspecialchars($userClan['clan_id']); ?>">

                <div class="mb-4">
                    <label for="castle_id" class="block text-gray-700 text-sm font-semibold mb-2">Selecionar Castelo:</label>
                    <select
                        id="castle_id"
                        name="castle_id"
                        class="shadow-sm appearance-none border rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 ease-in-out"
                        required
                    >
                        <option value="">-- Selecione um Castelo --</option>
                        <?php
                        // Exemplo de como você passaria e listaria os castelos disponíveis.
                        // No SiegeController::registerForm(), você precisaria buscar $availableCastles
                        // e passá-los para a view.
                        /*
                        if (isset($availableCastles) && is_array($availableCastles)) {
                            foreach ($availableCastles as $castle) {
                                echo '<option value="' . htmlspecialchars($castle['id']) . '">' . htmlspecialchars($castle['name']) . '</option>';
                            }
                        }
                        */
                        ?>
                        <!-- Exemplo de castelos fixos para demonstração, remova em produção -->
                        <option value="1">Gludio Castle</option>
                        <option value="2">Dion Castle</option>
                        <option value="3">Giran Castle</option>
                        <option value="4">Oren Castle</option>
                        <option value="5">Aden Castle</option>
                        <option value="6">Innadril Castle</option>
                        <option value="7">Goddard Castle</option>
                        <option value="8">Rune Castle</option>
                        <option value="9">Schuttgart Castle</option>
                    </select>
                </div>

                <div class="flex items-center justify-between">
                    <button
                        type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition duration-200 ease-in-out w-full"
                    >
                        Registrar Clã para Siege
                    </button>
                </div>
            </form>
        <?php else: ?>
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Atenção!</strong>
                <span class="block sm:inline">Você precisa ser um líder de clã para se registrar para uma siege.</span>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
