<?php
// index.php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Carrega variáveis do .env
$envPath = __DIR__ . '/.env';
if (file_exists($envPath)) {
    $env = parse_ini_file($envPath, false, INI_SCANNER_RAW);
    if ($env) {
        define('DB_TYPE', $env['DB_TYPE'] ?? 'mysql');
        define('DB_HOST', $env['DB_HOST'] ?? 'seuhost');
        define('DB_PORT', $env['DB_PORT'] ?? '3306');
        define('DB_NAME', $env['DB_NAME'] ?? 'suadatabase');
        define('DB_USER', $env['DB_USER'] ?? 'seuroot');
        define('DB_PASS', $env['DB_PASS'] ?? 'suasenha');
        define('TIMEZONE', $env['TIMEZONE'] ?? 'suatimezone');
        define('SITE_NAME', $env['SITE_NAME'] ?? 'SeuSite');
        define('APP_KEY', $env['APP_KEY'] ?? 'suakey');
        date_default_timezone_set(TIMEZONE);
    }
} else {
    die("Arquivo .env não encontrado.");
}

// C:\laragon\www\index.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Autoloader (Composer ou manual)
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
} else {
spl_autoload_register(function ($class) {
    $classPath = __DIR__ . '/app/' . str_replace('App\\', '', $class) . '.php';
    $classPath = str_replace('\\', '/', $classPath);
    if (file_exists($classPath)) {
        require_once $classPath;
    } else {
        echo "Classe não encontrada: $class<br>";
        echo "Caminho esperado: $classPath<br>";
    }
});

}

// Roteamento por query string
$page = $_GET['page'] ?? 'home';

use App\Controllers\{
    RankingController,
    LojaController,
    BossController,
    SiegeController,
    HeroController,
    DonateController,
    VoteController,
    AdminController,
    AuthController
};

switch ($page) {
    case 'ranking':
        RankingController::index();
        break;
    case 'loja':
        LojaController::index();
        break;
    case 'bosses':
        BossController::index();
        break;
    case 'sieges':
        SiegeController::index();
        break;
    case 'heroes':
        HeroController::index();
        break;
    case 'donate':
        DonateController::index();
        break;
    case 'vote':
        VoteController::index();
        break;
    case 'votar':
        VoteController::votar();
        break;
    case 'login':
        AuthController::loginForm();
        break;
    case 'logout':
        AuthController::logout();
        break;
    case 'painel':
    case 'admin':
        AdminController::dashboard();
        break;
    default:
        $view = __DIR__ . '/app/views/home.php';
        include __DIR__ . '/app/views/layouts/site.php';
        break;
}
