<?php
namespace App\Controllers;

use App\Models\Castle;
use App\Models\Clan; // Importa o modelo Clan
use App\Core\View; // Importa a classe View
use App\Core\DB; // Para interagir com o banco de dados
use App\Middleware\AuthMiddleware; // Assumindo que o registro de siege requer autenticação

class SiegeController
{
    public static function index()
    {
        $castelos = Castle::getAllWithOwners(); // Assume que Castle::getAllWithOwners() retorna os dados necessários

        // Prepara os dados para a view
        $data = [
            'pageTitle' => 'Informações de Cerco (Siege)',
            'castelos' => $castelos,
            'successMessage' => $_SESSION['success_message'] ?? null,
            'errorMessage' => $_SESSION['error_message'] ?? null,
        ];

        // Limpa as mensagens da sessão após passá-las para a view
        unset($_SESSION['success_message']);
        unset($_SESSION['error_message']);

        // Renderiza a view 'sieges/index' usando o layout principal do site
        View::render('sieges/index', $data, 'layout/main');
    }

    /**
     * Exibe o formulário de registro para siege.
     */
    public static function registerForm()
    {
        AuthMiddleware::check(); // Apenas líderes de clã logados podem ver o formulário

        $userClan = null;
        if (isset($_SESSION['user']['login'])) {
            $userClan = Clan::findByLeaderAccount($_SESSION['user']['login']);
        }

        // Você pode buscar informações sobre os castelos disponíveis para registro aqui.
        // Ex: $availableCastles = DB::select("SELECT id, name FROM castle WHERE siege_status = 'registrable'");

        $data = [
            'pageTitle' => 'Registrar para Siege',
            'userClan' => $userClan, // Passa os dados do clã do usuário para a view
            // 'availableCastles' => $availableCastles,
            'successMessage' => $_SESSION['success_message'] ?? null,
            'errorMessage' => $_SESSION['error_message'] ?? null,
        ];

        unset($_SESSION['success_message']);
        unset($_SESSION['error_message']);

        View::render('sieges/register', $data, 'layout/main');
    }

    /**
     * Processa o registro de um clã para uma siege.
     */
    public static function processRegistration()
    {
        AuthMiddleware::check(); // Apenas líderes de clã logados podem processar o registro

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $clanId = (int) ($_POST['clan_id'] ?? 0); // ID do clã que está se registrando
            $castleId = (int) ($_POST['castle_id'] ?? 0); // ID do castelo para o qual o clã quer se registrar
            $leaderAccount = $_SESSION['user']['login']; // Login do líder do clã

            // 1. Validação: O usuário logado é realmente o líder do clã e o clã existe?
            $userClan = Clan::findByLeaderAccount($leaderAccount);

            if (!$userClan || $userClan['clan_id'] !== $clanId) {
                $_SESSION['error_message'] = "Você não é o líder do clã selecionado ou o clã não existe.";
                header("Location: /siege/register");
                exit;
            }

            // 2. Validar nível do clã (ex: mínimo nível 4 para siege)
            $minClanLevelForSiege = 4; // Regra comum do L2
            if (($userClan['clan_level'] ?? 0) < $minClanLevelForSiege) { // Usando ?? 0 para evitar erro se clan_level não existir
                $_SESSION['error_message'] = "Seu clã deve ser nível " . $minClanLevelForSiege . " ou superior para se registrar para siege.";
                header("Location: /siege/register");
                exit;
            }

            // 3. Validar se o castelo é válido e está no período de registro
            $castle = DB::selectOne("SELECT * FROM castle WHERE id = ?", [$castleId]);

            if (!$castle) {
                $_SESSION['error_message'] = "Castelo inválido.";
                header("Location: /siege/register");
                exit;
            }

            // Placeholder para a lógica de verificação do período de registro do castelo.
            // Você precisará implementar isso com base nas colunas da sua tabela 'castle'.
            // Exemplo:
            // if ($castle['siege_status'] !== 'registrable' || time() > strtotime($castle['registration_end_date'])) {
            //     $_SESSION['error_message'] = "O castelo não está em período de registro.";
            //     header("Location: /siege/register");
            //     exit;
            // }

            // 4. Verificar se o clã já não está registrado para esta siege (para evitar duplicatas)
            $existingRegistration = DB::selectOne("SELECT * FROM siege_clans WHERE castle_id = ? AND clan_id = ?", [$castleId, $clanId]);

            if ($existingRegistration) {
                $_SESSION['error_message'] = "Seu clã já está registrado para esta siege.";
                header("Location: /siege/register");
                exit;
            }

            // 5. Inserir o registro na tabela de sieges do L2J
            // Assumindo a tabela 'siege_clans' com colunas 'castle_id', 'clan_id', 'type', 'registered_date'
            DB::execute("INSERT INTO siege_clans (castle_id, clan_id, type, registered_date) VALUES (?, ?, 'attacker', NOW())", [
                $castleId, $clanId
            ]);

            $_SESSION['success_message'] = "Clã registrado com sucesso para a siege!";
            header("Location: /siege"); // Redireciona para a página principal de sieges
            exit;

        } else {
            http_response_code(405); // Método não permitido se não for POST
            echo "Método não permitido.";
        }
    }
}
