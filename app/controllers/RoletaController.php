<?php
namespace App\Controllers;

use App\Core\DB;
use App\Core\View; // Importa a classe View
use App\Middleware\AuthMiddleware; // Assumindo que a roleta requer autenticação

class RoletaController
{
    public static function index()
    {
        AuthMiddleware::check(); // Garante que o usuário esteja logado para acessar a roleta

        // Você pode buscar dados da roleta para exibir na view aqui, se houver
        // Ex: $rewards = DB::select("SELECT * FROM rewards WHERE type = 'roleta' AND is_active = 1");

        $data = [
            'pageTitle' => 'Roleta da Sorte',
            // 'rewards' => $rewards, // Se você buscar dados para a view
            'successMessage' => $_SESSION['success_message'] ?? null,
            'errorMessage' => $_SESSION['error_message'] ?? null,
        ];

        unset($_SESSION['success_message']);
        unset($_SESSION['error_message']);

        View::render('roleta/index', $data, 'layout/main');
    }

    public static function girar()
    {
        // AuthMiddleware::check() já deve ser chamado na rota ou no início do método,
        // mas é bom ter uma verificação aqui também, ou garantir que a rota seja protegida.
        if (!isset($_SESSION['user'])) {
            $_SESSION['error_message'] = "Você precisa estar logado para girar a roleta.";
            header("Location: /login");
            exit;
        }

        $charName = $_POST['char_name'] ?? '';
        $account = $_SESSION['user']['login'];

        // Validação básica
        if (empty($charName)) {
            $_SESSION['error_message'] = "Nome do personagem é obrigatório.";
            header("Location: /roleta"); // Redireciona de volta para a página da roleta
            exit;
        }

        // Validação do personagem
        $char = DB::selectOne("SELECT * FROM characters WHERE char_name = ? AND account_name = ?", [
            $charName, $account
        ]);

        if (!$char) {
            $_SESSION['error_message'] = "Personagem inválido ou não pertence à conta logada.";
            header("Location: /roleta");
            exit;
        }

        // Lógica para custo do giro (ex: deduzir adena ou um item)
        // Você precisará implementar isso aqui, se houver um custo para girar a roleta.
        // Exemplo:
        // $cost = 1000000; // 1 milhão de adena
        // if ($char['adena'] < $cost) {
        //     $_SESSION['error_message'] = "Você não tem adena suficiente para girar a roleta.";
        //     header("Location: /roleta");
        //     exit;
        // }
        // DB::execute("UPDATE characters SET adena = adena - ? WHERE obj_Id = ?", [$cost, $char['obj_Id']]);


        // Buscar recompensa aleatória
        // Assumimos que 'rewards' tem 'type = roleta' e 'is_active = 1'
        $reward = DB::selectOne("SELECT * FROM rewards WHERE type = 'roleta' AND is_active = 1 ORDER BY RAND() LIMIT 1");

        if ($reward) {
            // Inserir item para entrega
            DB::execute("INSERT INTO items_deliver (char_name, item_id, amount, enchant) VALUES (?, ?, ?, ?)", [
                $charName, $reward['item_id'], $reward['amount'], $reward['enchant'] ?? 0 // Garante um valor padrão para enchant
            ]);
            $_SESSION['success_message'] = "Parabéns! Você ganhou " . htmlspecialchars($reward['name'] ?? 'um item') . "!"; // Assumindo que 'name' existe na tabela rewards
        } else {
            $_SESSION['error_message'] = "Nenhuma recompensa disponível na roleta no momento. Tente novamente mais tarde.";
        }

        header("Location: /roleta");
        exit;
    }
}
