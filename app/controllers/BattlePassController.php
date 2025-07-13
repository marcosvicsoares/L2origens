<?php
namespace App\Controllers;

use App\Core\DB;
use App\Core\View; // Importa a classe View
use App\Middleware\AuthMiddleware; // Assumindo que você tem um AuthMiddleware para verificar o login

class BattlePassController
{
    public static function index()
    {
        AuthMiddleware::check(); // Garante que o usuário esteja logado

        // Você pode buscar dados do Battle Pass para exibir na view aqui
        // Ex: $tiers = DB::select("SELECT * FROM battlepass_tiers ORDER BY tier ASC");

        $data = [
            'pageTitle' => 'Battle Pass',
            // 'tiers' => $tiers, // Se você buscar dados para a view
            'successMessage' => $_SESSION['success_message'] ?? null,
            'errorMessage' => $_SESSION['error_message'] ?? null,
        ];

        unset($_SESSION['success_message']);
        unset($_SESSION['error_message']);

        View::render('battlepass/index', $data, 'layout/main');
    }

    public static function claimReward()
    {
        // AuthMiddleware::check() já deve ser chamado na rota ou no início do método,
        // mas é bom ter uma verificação aqui também, ou garantir que a rota seja protegida.
        // Se o AuthMiddleware redireciona, as linhas abaixo podem não ser alcançadas.
        if (!isset($_SESSION['user'])) {
            $_SESSION['error_message'] = "Você precisa estar logado para resgatar recompensas.";
            header("Location: /login");
            exit;
        }

        $charName = $_POST['char_name'] ?? '';
        $tier = (int) ($_POST['tier'] ?? 0); // Garante que seja um inteiro
        $account = $_SESSION['user']['login'];

        // Validação básica
        if (empty($charName) || $tier <= 0) {
            $_SESSION['error_message'] = "Nome do personagem e tier são obrigatórios e devem ser válidos.";
            header("Location: /battlepass"); // Redireciona de volta para a página do battlepass
            exit;
        }

        // Validação do personagem
        // Usando DB::selectOne para buscar uma única linha
        $char = DB::selectOne("SELECT * FROM characters WHERE char_name = ? AND account_name = ?", [
            $charName, $account
        ]);

        if (!$char) {
            $_SESSION['error_message'] = "Personagem inválido ou não pertence à conta logada.";
            header("Location: /battlepass");
            exit;
        }

        // Buscar recompensa do tier
        // Usando DB::selectOne para buscar uma única linha
        $reward = DB::selectOne("SELECT * FROM rewards WHERE type = 'battlepass' AND tier = ? AND is_active = 1", [
            $tier
        ]);

        if ($reward) {
            // Inserir item para entrega
            // Usando DB::execute para operações de INSERT
            DB::execute("INSERT INTO items_deliver (char_name, item_id, amount, enchant) VALUES (?, ?, ?, ?)", [
                $charName, $reward['item_id'], $reward['amount'], $reward['enchant']
            ]);
            $_SESSION['success_message'] = "Recompensa do Tier " . $tier . " resgatada com sucesso!";
        } else {
            $_SESSION['error_message'] = "Recompensa do Tier " . $tier . " não encontrada ou não ativa.";
        }

        header("Location: /battlepass");
        exit;
    }
}
