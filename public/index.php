<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/core/Env.php';
\App\Core\Env::load();

use App\Controllers\RankingController;
use App\Controllers\LojaController;
use App\Controllers\BossController;
use App\Controllers\SiegeController;
use App\Controllers\HeroController;
use App\Controllers\DonateController;

$uri = $_SERVER['REQUEST_URI'];

if ($uri === '/' || $uri === '/home') {
    $view = __DIR__ . '/../app/views/home.php';
    include __DIR__ . '/../app/views/layouts/site.php';
} elseif (str_starts_with($uri, '/ranking')) {
    RankingController::index();
} elseif (str_starts_with($uri, '/loja')) {
    LojaController::index();
} elseif (str_starts_with($uri, '/bosses')) {
    BossController::index();
} elseif (str_starts_with($uri, '/sieges')) {
    SiegeController::index();
} elseif (str_starts_with($uri, '/heroes')) {
    HeroController::index();
} elseif (str_starts_with($uri, '/donate/retorno')) {
    DonateController::retorno();
} elseif (str_starts_with($uri, '/donate')) {
    DonateController::index();
} 
elseif (str_starts_with($uri, '/vote/votar')) {
    \App\Controllers\VoteController::votar();
} elseif (str_starts_with($uri, '/vote')) {
    \App\Controllers\VoteController::index();
} elseif (str_starts_with($uri, '/admin/votos')) {
    \App\Controllers\AdminVotosController::index();
}
 elseif (str_starts_with($uri, '/admin/rewards')) {
    \App\Controllers\AdminRewardsController::index();
}
elseif ($uri === '/admin/rewards/send') {
    \App\Controllers\AdminRewardsController::send();
}
elseif ($uri === '/admin/events/create') {
    \App\Controllers\AdminEventsController::create();
} elseif (str_starts_with($uri, '/admin/events')) {
    \App\Controllers\AdminEventsController::index();
}
elseif (str_starts_with($uri, '/admin/logs')) {
    \App\Controllers\AdminLogsController::index();
}

 elseif ($uri === '/painel' || str_starts_with($uri, '/admin')) {
    \App\Controllers\AdminController::dashboard();
} elseif (str_starts_with($uri, '/login')) {
    \App\Controllers\AuthController::loginForm();
} elseif ($uri === '/logout') {
    \App\Controllers\AuthController::logout();
}

else {
    http_response_code(404);
    echo "Página não encontrada.";
}
