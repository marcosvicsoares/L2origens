<?php
namespace App\Core;

// Controladores públicos
use App\Controllers\HomeController;
use App\Controllers\RankingController;
use App\Controllers\LojaController;
use App\Controllers\BossController;
use App\Controllers\SiegeController;
use App\Controllers\HeroController;
use App\Controllers\DonateController;
use App\Controllers\VoteController;
use App\Controllers\AuthController;
use App\Controllers\RoletaController; // Controlador da Roleta pública

// Controladores administrativos
use App\Controllers\AdminController;
use App\Controllers\AdminVotosController;
use App\Controllers\AdminRewardsController;
use App\Controllers\AdminEventsController;
use App\Controllers\AdminLogsController;
use App\Controllers\AdminBattlePassController; // NOVO: Controlador do Battle Pass Admin
use App\Controllers\AdminRoletaController;     // NOVO: Controlador da Roleta Admin
use App\Controllers\AdminSiegeController;      // NOVO: Controlador de Gerenciamento de Sieges Admin
use App\Controllers\AdminLojaController;       // NOVO: Controlador da Loja Admin

class Router
{
    /**
     * Roteia a requisição URI para o controlador e método apropriados.
     *
     * @param string $uri A URI da requisição.
     */
    public static function route($uri)
    {
        // Remove parâmetros de query da URI (tudo após '?')
        $uri = strtok($uri, '?');
        // Obtém o método da requisição (GET, POST, PUT, DELETE, etc.)
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        // Normaliza a URI: remove barras extras e garante que comece com '/'
        // Ex: '/admin/users/' se torna '/admin/users'
        // Ex: 'admin/users' se torna '/admin/users'
        // Ex: '' se torna '/'
        $path = '/' . trim(parse_url($uri, PHP_URL_PATH), '/');

        // Divide o caminho em segmentos para análise de rotas dinâmicas
        // Ex: '/admin/battlepass/edit/1' -> ['', 'admin', 'battlepass', 'edit', '1']
        $segments = explode('/', $path);
        // Remove o primeiro segmento vazio resultante de uma URI que começa com '/'
        // Ex: ['', 'admin', 'battlepass', 'edit', '1'] -> ['admin', 'battlepass', 'edit', '1']
        array_shift($segments); // Remove o primeiro elemento (vazio)

        // --- Rotas Públicas ---
        // As rotas públicas são tratadas primeiro para evitar conflitos com rotas administrativas de mesmo nome.
        switch ($path) {
            case '/':
            case '/home':
                HomeController::index();
                return;
            case '/ranking':
                RankingController::index();
                return;
            case '/loja':
                LojaController::index();
                return;
            case '/bosses':
                BossController::index();
                return;
            case '/sieges':
                SiegeController::index();
                return;
            case '/heroes':
                HeroController::index();
                return;
            case '/donate/retorno':
                DonateController::retorno();
                return;
            case '/donate':
                DonateController::index();
                return;
            case '/vote/votar':
                VoteController::votar();
                return;
            case '/vote':
                VoteController::index();
                return;
            case '/roleta':
                // Rota pública para a roleta (girar, ver prêmios, etc.)
                if ($requestMethod === 'GET') {
                    RoletaController::index();
                } elseif ($requestMethod === 'POST') {
                    RoletaController::girar();
                } else {
                    http_response_code(405); // Method Not Allowed
                    echo "Método não permitido para /roleta.";
                }
                return;
            case '/login':
                if ($requestMethod === 'GET') {
                    AuthController::loginForm();
                } elseif ($requestMethod === 'POST') {
                    AuthController::login();
                } else {
                    http_response_code(405); // Method Not Allowed
                    echo "Método não permitido para /login.";
                }
                return;
            case '/logout':
                AuthController::logout();
                return;
        }

        // --- Rotas Administrativas ---
        // Verifica se o primeiro segmento da URI é 'admin'
        if (isset($segments[0]) && $segments[0] === 'admin') {
            // Rota para o dashboard administrativo
            if ($path === '/admin' || $path === '/painel') {
                AdminController::dashboard();
                return;
            }

            // Verifica qual módulo administrativo está sendo acessado
            if (isset($segments[1])) {
                switch ($segments[1]) {
                    case 'votos':
                        AdminVotosController::index();
                        return;
                    case 'rewards':
                        if (!isset($segments[2])) { // /admin/rewards (listagem)
                            AdminRewardsController::index();
                        } elseif ($segments[2] === 'send' && $requestMethod === 'POST') { // /admin/rewards/send (envio)
                            AdminRewardsController::send();
                        } else {
                            http_response_code(404);
                            echo "Página não encontrada para /admin/rewards.";
                        }
                        return;
                    case 'events':
                        if (!isset($segments[2])) { // /admin/events (listagem)
                            AdminEventsController::index();
                        } elseif ($segments[2] === 'create') { // /admin/events/create (formulário ou processamento)
                            if ($requestMethod === 'GET') {
                                AdminEventsController::createForm(); // Assumindo um método createForm
                            } elseif ($requestMethod === 'POST') {
                                AdminEventsController::create();
                            } else {
                                http_response_code(405);
                                echo "Método não permitido para /admin/events/create.";
                            }
                        } else {
                            http_response_code(404);
                            echo "Página não encontrada para /admin/events.";
                        }
                        return;
                    case 'logs':
                        AdminLogsController::index();
                        return;

                    // --- NOVOS MÓDULOS DO PAINEL ---

                    case 'battlepass':
                        if (!isset($segments[2])) { // /admin/battlepass (listagem)
                            AdminBattlePassController::index();
                        } elseif ($segments[2] === 'create') { // /admin/battlepass/create (formulário ou processamento)
                            if ($requestMethod === 'GET') {
                                AdminBattlePassController::createForm();
                            } elseif ($requestMethod === 'POST') {
                                AdminBattlePassController::create();
                            } else {
                                http_response_code(405);
                                echo "Método não permitido para /admin/battlepass/create.";
                            }
                        } elseif ($segments[2] === 'edit' && isset($segments[3])) { // /admin/battlepass/edit/{id} (formulário ou processamento)
                            $id = (int) $segments[3]; // Captura o ID
                            if ($requestMethod === 'GET') {
                                AdminBattlePassController::editForm($id);
                            } elseif ($requestMethod === 'POST') {
                                AdminBattlePassController::update($id);
                            } else {
                                http_response_code(405);
                                echo "Método não permitido para /admin/battlepass/edit.";
                            }
                        } elseif ($segments[2] === 'delete' && isset($segments[3])) { // /admin/battlepass/delete/{id} (exclusão)
                            $id = (int) $segments[3];
                            // Recomenda-se usar POST para exclusão em um ambiente real
                            AdminBattlePassController::delete($id);
                        } else {
                            http_response_code(404);
                            echo "Página não encontrada para /admin/battlepass.";
                        }
                        return;

                    case 'roleta':
                        if (!isset($segments[2])) { // /admin/roleta (listagem)
                            AdminRoletaController::index();
                        } elseif ($segments[2] === 'create') { // /admin/roleta/create (formulário ou processamento)
                            if ($requestMethod === 'GET') {
                                AdminRoletaController::createForm();
                            } elseif ($requestMethod === 'POST') {
                                AdminRoletaController::create();
                            } else {
                                http_response_code(405);
                                echo "Método não permitido para /admin/roleta/create.";
                            }
                        } elseif ($segments[2] === 'edit' && isset($segments[3])) { // /admin/roleta/edit/{id} (formulário ou processamento)
                            $id = (int) $segments[3];
                            if ($requestMethod === 'GET') {
                                AdminRoletaController::editForm($id);
                            } elseif ($requestMethod === 'POST') {
                                AdminRoletaController::update($id);
                            } else {
                                http_response_code(405);
                                echo "Método não permitido para /admin/roleta/edit.";
                            }
                        } elseif ($segments[2] === 'delete' && isset($segments[3])) { // /admin/roleta/delete/{id} (exclusão)
                            $id = (int) $segments[3];
                            AdminRoletaController::delete($id);
                        } else {
                            http_response_code(404);
                            echo "Página não encontrada para /admin/roleta.";
                        }
                        return;

                    case 'sieges': // Gerenciamento de Sieges no Admin (diferente da rota pública /sieges)
                        if (!isset($segments[2])) { // /admin/sieges (listagem)
                            AdminSiegeController::index();
                        } elseif ($segments[2] === 'create') { // /admin/sieges/create (formulário ou processamento)
                            if ($requestMethod === 'GET') {
                                AdminSiegeController::createForm();
                            } elseif ($requestMethod === 'POST') {
                                AdminSiegeController::create();
                            } else {
                                http_response_code(405);
                                echo "Método não permitido para /admin/sieges/create.";
                            }
                        } elseif ($segments[2] === 'edit' && isset($segments[3])) { // /admin/sieges/edit/{id} (formulário ou processamento)
                            $id = (int) $segments[3];
                            if ($requestMethod === 'GET') {
                                AdminSiegeController::editForm($id);
                            } elseif ($requestMethod === 'POST') {
                                AdminSiegeController::update($id);
                            } else {
                                http_response_code(405);
                                echo "Método não permitido para /admin/sieges/edit.";
                            }
                        } elseif ($segments[2] === 'delete' && isset($segments[3])) { // /admin/sieges/delete/{id} (exclusão)
                            $id = (int) $segments[3];
                            AdminSiegeController::delete($id);
                        } else {
                            http_response_code(404);
                            echo "Página não encontrada para /admin/sieges.";
                        }
                        return;

                    case 'loja':
                        if (!isset($segments[2])) { // /admin/loja (listagem)
                            AdminLojaController::index();
                        } elseif ($segments[2] === 'create') { // /admin/loja/create (formulário ou processamento)
                            if ($requestMethod === 'GET') {
                                AdminLojaController::createForm();
                            } elseif ($requestMethod === 'POST') {
                                AdminLojaController::create();
                            } else {
                                http_response_code(405);
                                echo "Método não permitido para /admin/loja/create.";
                            }
                        } elseif ($segments[2] === 'edit' && isset($segments[3])) { // /admin/loja/edit/{id} (formulário ou processamento)
                            $id = (int) $segments[3];
                            if ($requestMethod === 'GET') {
                                AdminLojaController::editForm($id);
                            } elseif ($requestMethod === 'POST') {
                                AdminLojaController::update($id);
                            } else {
                                http_response_code(405);
                                echo "Método não permitido para /admin/loja/edit.";
                            }
                        } elseif ($segments[2] === 'delete' && isset($segments[3])) { // /admin/loja/delete/{id} (exclusão)
                            $id = (int) $segments[3];
                            AdminLojaController::delete($id);
                        } else {
                            http_response_code(404);
                            echo "Página não encontrada para /admin/loja.";
                        }
                        return;

                    default:
                        // Se o segundo segmento não corresponder a nenhum módulo admin conhecido
                        http_response_code(404);
                        echo "Página administrativa não encontrada.";
                        return;
                }
            }
        }

        // Se nenhuma rota corresponder (nem pública, nem administrativa)
        http_response_code(404);
        echo "Página não encontrada.";
    }
}
