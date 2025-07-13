<?php
namespace App\Controllers;

use App\Middleware\AuthMiddleware;
use App\Core\View; // Importa a classe View

class DonateController
{
    public static function index()
    {
        AuthMiddleware::check(); // Garante que o usuário esteja logado

        // Prepara os dados para a view
        $data = [
            'pageTitle' => 'Doações',
            'successMessage' => $_SESSION['success_message'] ?? null,
            'errorMessage' => $_SESSION['error_message'] ?? null,
        ];

        // Limpa as mensagens da sessão após passá-las para a view
        unset($_SESSION['success_message']);
        unset($_SESSION['error_message']);

        // Renderiza a view 'donate/index' usando o layout principal do site
        View::render('donate/index', $data, 'layout/main');
    }

    public static function retorno()
    {
        // Aqui você trataria a confirmação do PayPal IPN ou retorno PDT
        // Exemplo: verificar se foi pago e registrar no banco de dados.
        // Você pode adicionar lógica para processar os dados de retorno aqui.

        // Prepara os dados para a view
        $data = [
            'pageTitle' => 'Retorno da Doação',
            'statusMessage' => 'Sua doação foi processada. Verifique seu histórico de transações.', // Mensagem de exemplo
            // Você pode adicionar mais dados aqui com base no retorno do PayPal
        ];

        // Renderiza a view 'donate/return' usando o layout principal do site
        View::render('donate/return', $data, 'layout/main');
    }
}
