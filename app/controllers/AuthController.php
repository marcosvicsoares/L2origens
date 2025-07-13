<?php
namespace App\Controllers;

use PDO;
use App\Models\User;
use App\Core\View; // Importa a classe View

class AuthController
{
    // Exibe o formulário de login
    public static function loginForm()
    {
        // Prepara os dados para a view
        $data = [
            'pageTitle' => 'Login',
            // Passa mensagens de erro/sucesso da sessão para a view, se existirem
            'errorMessage' => $_SESSION['error_message'] ?? null,
            'successMessage' => $_SESSION['success_message'] ?? null,
        ];

        // Limpa as mensagens da sessão após passá-las para a view
        unset($_SESSION['error_message']);
        unset($_SESSION['success_message']);

        // Renderiza a view 'auth/login' usando o layout padrão (layout/main)
        // Se você tiver um layout específico para autenticação, pode especificar aqui.
        View::render('auth/login', $data, 'layout/main');
    }

    // Processa o login
    public static function login()
    {
        $login = $_POST['login'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($login) || empty($password)) {
            $_SESSION['error_message'] = "Login e senha são obrigatórios.";
            header("Location: /login");
            exit;
        }

        // Verifica o usuário no banco
        $user = User::findByLogin($login);
        if (!$user) {
            $_SESSION['error_message'] = "Conta não encontrada.";
            header("Location: /login");
            exit;
        }

        // Verifica a senha (sem criptografia ou md5 conforme .env)
        // Certifique-se de que PASSWORD_ENCRYPTION está definida em seu arquivo .env
        $passEncryption = $_ENV['PASSWORD_ENCRYPTION'] ?? 'none'; 
        $passwordCheck = match ($passEncryption) {
            'md5' => md5($password),
            'sha1' => sha1($password),
            default => $password
        };

        if ($user['password'] !== $passwordCheck) {
            $_SESSION['error_message'] = "Senha incorreta.";
            header("Location: /login");
            exit;
        }

        // Autenticado com sucesso
        $_SESSION['user'] = [
            'login' => $user['login'],
            'accessLevel' => $user['accessLevel'] ?? 0
        ];

        $_SESSION['success_message'] = "Login realizado com sucesso!";
        header("Location: /painel"); // Redireciona para o painel após o login
        exit;
    }

    // Faz logout
    public static function logout()
    {
        session_destroy();
        header("Location: /login");
        exit;
    }
}
