<?php
namespace App\Controllers;

use App\Middleware\AdminMiddleware;
use App\Core\DB;
use App\Core\View; // Importa a classe View

class AdminRewardsController
{
    public static function index()
    {
        AdminMiddleware::check();
        $rewards = DB::select("SELECT * FROM rewards ORDER BY id DESC LIMIT 100");

        // Prepara os dados para a view
        $data = [
            'pageTitle' => 'Gerenciar Recompensas',
            'rewards' => $rewards,
        ];

        // Renderiza a view 'admin/rewards' usando o layout 'layout/admin'
        View::render('admin/rewards', $data, 'layout/admin');
    }

    public static function send()
    {
        AdminMiddleware::check();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $char_name = $_POST['char_name'] ?? '';
            $item_id   = (int) ($_POST['item_id'] ?? 0); // Garante que é um inteiro
            $amount    = (int) ($_POST['amount'] ?? 0);  // Garante que é um inteiro
            $enchant   = (int) ($_POST['enchant'] ?? 0); // Garante que é um inteiro

            // Validação básica
            if (empty($char_name) || $item_id <= 0 || $amount <= 0) {
                $_SESSION['error_message'] = "Nome do personagem, ID do item e quantidade são obrigatórios e devem ser válidos.";
                header('Location: /admin/rewards'); // Redireciona de volta ao formulário
                exit;
            }

            // Envio: insere em uma tabela de recompensas pendentes ou entrega direta via DB
            // Usando DB::execute para operações de INSERT
            DB::execute("INSERT INTO rewards_pending (char_name, item_id, amount, enchant, created_at) VALUES (?, ?, ?, ?, NOW())", [
                $char_name, $item_id, $amount, $enchant
            ]);

            // Inserir log da ação administrativa:
            DB::execute("INSERT INTO admin_logs (admin_login, action) VALUES (?, ?)", [
                $_SESSION['user']['login'], 'Enviou recompensa para ' . $char_name . ' (Item ID: ' . $item_id . ')'
            ]);

            $_SESSION['success_message'] = "Recompensa enviada com sucesso!";
            header('Location: /admin/rewards');
            exit;
        }

        // Se a requisição não for POST, você pode renderizar um formulário ou uma mensagem de erro.
        // Para este caso, o `http_response_code(405)` já indica "Método Não Permitido".
        http_response_code(405);
        echo "Método não permitido.";
    }
}
