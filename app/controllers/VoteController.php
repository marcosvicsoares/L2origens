<?php
namespace App\Controllers;

use App\Core\DB;
use App\Core\View; // Importa a classe View
use App\Middleware\AuthMiddleware; // Assumindo que a ação de votar pode requerer autenticação

class VoteController
{
    public static function index()
    {
        // Não é necessário AuthMiddleware::check() aqui se a página é acessível a visitantes,
        // mas a variável $account ainda pode ser preenchida com o login do usuário se ele estiver logado.
        // A sessão já é iniciada globalmente no index.php.

        $sites = [
            'Hopzone' => 'https://l2.hopzone.net/',
            'Topzone' => 'https://l2topzone.com/'
        ];

        $ip = $_SERVER['REMOTE_ADDR'];
        $account = $_SESSION['user']['login'] ?? 'visitante'; // Permite "visitante" se não logado
        $waitHours = 12; // Tempo de espera entre os votos

        $cooldowns = [];
        $status = []; // Inicializa o array de status

        foreach ($sites as $site => $url) {
            $lastVote = DB::selectOne("SELECT voted_at FROM vote_logs WHERE site = ? AND ip_address = ? ORDER BY voted_at DESC LIMIT 1", [
                $site, $ip
            ]);

            $canVote = true;
            if ($lastVote) {
                $last = strtotime($lastVote['voted_at']);
                $now = time();
                $diff = $now - $last;

                if ($diff < ($waitHours * 3600)) {
                    $canVote = false;
                    // Calcula o tempo restante para o cooldown
                    $cooldowns[$site] = gmdate("H:i:s", ($waitHours * 3600 - $diff));
                }
            }

            $status[$site] = $canVote;
        }

        // Prepara os dados para a view
        $data = [
            'pageTitle' => 'Votação',
            'sites' => $sites,
            'status' => $status,
            'cooldowns' => $cooldowns,
            'successMessage' => $_SESSION['success_message'] ?? null,
            'errorMessage' => $_SESSION['error_message'] ?? null,
        ];

        // Limpa as mensagens da sessão após passá-las para a view
        unset($_SESSION['success_message']);
        unset($_SESSION['error_message']);

        // Renderiza a view 'vote/index' usando o layout principal do site
        View::render('vote/index', $data, 'layout/main');
    }

   public static function votar()
    {
        // Garante que o usuário esteja logado para votar.
        // Se o AuthMiddleware::check() redireciona, as linhas abaixo podem não ser alcançadas.
        if (!isset($_SESSION['user'])) {
            $_SESSION['error_message'] = "Você precisa estar logado para votar.";
            header("Location: /login");
            exit;
        }

        $site = $_GET['site'] ?? null;
        $ip = $_SERVER['REMOTE_ADDR'];
        $account = $_SESSION['user']['login'] ?? 'visitante'; // Usa 'visitante' se não logado, embora a verificação acima já trate isso.

        $validSites = [
            'Hopzone' => 'https://l2.hopzone.net/',
            'Topzone' => 'https://l2topzone.com/'
        ];

        if (!isset($validSites[$site])) {
            $_SESSION['error_message'] = "Site de votação inválido.";
            header("Location: /vote");
            exit;
        }

        // Verifica se o IP já votou nesse site nas últimas 12 horas
        $lastVote = DB::selectOne("SELECT voted_at FROM vote_logs WHERE site = ? AND ip_address = ? ORDER BY voted_at DESC LIMIT 1", [
            $site, $ip
        ]);

        $waitHours = 12; // Tempo de espera entre os votos
        if ($lastVote) {
            $last = strtotime($lastVote['voted_at']);
            $now = time();
            $diff = $now - $last;

            if ($diff < ($waitHours * 3600)) {
                $_SESSION['error_message'] = "Você já votou recentemente nesse site. Tente novamente mais tarde.";
                header("Location: /vote");
                exit;
            }
        }

        // Salva o log do voto
        // Usando DB::execute para operações de INSERT
        DB::execute("INSERT INTO vote_logs (account, ip_address, site) VALUES (?, ?, ?)", [
            $account, $ip, $site
        ]);

        $_SESSION['success_message'] = "Voto registrado com sucesso! Redirecionando para o site de votação...";
        // Redireciona para o site real de votação
        header("Location: " . $validSites[$site]);
        exit;
    }
}
