<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Inclui o Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Define a fonte Inter para todo o corpo */
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full">
        <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Entrar</h2>

        <!-- Formulário de Login -->
        <form action="/login" method="POST">
            <div class="mb-4">
                <label for="username_email" class="block text-gray-700 text-sm font-semibold mb-2">Usuário ou Email:</label>
                <input
                    type="text"
                    id="username_email"
                    name="username_email"
                    class="shadow-sm appearance-none border rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 ease-in-out"
                    placeholder="Seu usuário ou email"
                    required
                >
            </div>
            <div class="mb-6">
                <label for="password" class="block text-gray-700 text-sm font-semibold mb-2">Senha:</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="shadow-sm appearance-none border rounded-md w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 ease-in-out"
                    placeholder="Sua senha"
                    required
                >
            </div>
            <div class="flex items-center justify-between">
                <button
                    type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition duration-200 ease-in-out w-full"
                >
                    Login
                </button>
            </div>
            <div class="mt-6 text-center">
                <a href="/register" class="inline-block align-baseline font-bold text-sm text-blue-600 hover:text-blue-800">
                    Não tem uma conta? Registre-se
                </a>
            </div>
        </form>
    </div>
</body>
</html>
