<?php
namespace App\Controllers;

use App\Models\Shop;
use App\Core\View; // Importa a classe View
use App\Middleware\AuthMiddleware; // Assumindo que a loja requer autenticação

class LojaController
{
    public static function index()
    {
        AuthMiddleware::check(); // Garante que o usuário esteja logado para acessar a loja

        $items = Shop::getAll(); // Assume que Shop::getAll() já retorna os dados necessários

        // Prepara os dados para a view
        $data = [
            'pageTitle' => 'Loja de Itens',
            'items' => $items,
            'successMessage' => $_SESSION['success_message'] ?? null,
            'errorMessage' => $_SESSION['error_message'] ?? null,
        ];

        // Limpa as mensagens da sessão após passá-las para a view
        unset($_SESSION['success_message']);
        unset($_SESSION['error_message']);

        // Renderiza a view 'loja/index' usando o layout principal do site
        View::render('loja/index', $data, 'layout/main');
    }

    public static function comprar()
    {
        AuthMiddleware::check(); // Garante que o usuário esteja logado para comprar

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lógica para comprar item
            // Exemplo:
            $itemId = (int) ($_POST['item_id'] ?? 0);
            $characterName = $_POST['char_name'] ?? '';
            $account = $_SESSION['user']['login'];

            // Validação básica
            if ($itemId <= 0 || empty($characterName)) {
                $_SESSION['error_message'] = "Item inválido ou nome do personagem ausente.";
                header("Location: /loja");
                exit;
            }

            // 1. Verificar se o personagem pertence à conta
            $char = \App\Core\DB::selectOne("SELECT * FROM characters WHERE char_name = ? AND account_name = ?", [
                $characterName, $account
            ]);

            if (!$char) {
                $_SESSION['error_message'] = "Personagem inválido ou não pertence à sua conta.";
                header("Location: /loja");
                exit;
            }

            // 2. Buscar detalhes do item na loja (preço, etc.)
            $shopItem = \App\Core\DB::selectOne("SELECT * FROM shop_items WHERE item_id = ?", [$itemId]);

            if (!$shopItem) {
                $_SESSION['error_message'] = "Item não encontrado na loja.";
                header("Location: /loja");
                exit;
            }

            // 3. Verificar se o usuário tem saldo suficiente (ex: adena, coins)
            // Esta é uma lógica que você precisará implementar com base na sua DB.
            // Ex: $userBalance = \App\Core\DB::selectOne("SELECT adena FROM accounts WHERE login = ?", [$account]);
            // if ($userBalance['adena'] < $shopItem['price']) {
            //     $_SESSION['error_message'] = "Saldo insuficiente.";
            //     header("Location: /loja");
            //     exit;
            // }

            // 4. Processar a compra (deduzir saldo e entregar item)
            // Ex: \App\Core\DB::execute("UPDATE accounts SET adena = adena - ? WHERE login = ?", [$shopItem['price'], $account]);
            \App\Core\DB::execute("INSERT INTO items_deliver (char_name, item_id, amount, enchant) VALUES (?, ?, ?, ?)", [
                $characterName, $shopItem['item_id'], 1, ($shopItem['enchant'] ?? 0) // Assumindo quantidade 1 e enchant opcional
            ]);

            $_SESSION['success_message'] = "Item comprado e entregue com sucesso!";
            header("Location: /loja");
            exit;
        }

        http_response_code(405); // Método não permitido se não for POST
        echo "Método não permitido.";
    }
}
