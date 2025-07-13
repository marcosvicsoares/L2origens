<?php
namespace App\Middleware;

class AdminMiddleware
{
    public static function check()
    {
        session_start();
        if (!isset($_SESSION['user']) || $_SESSION['user']['access_level'] < 1) {
            http_response_code(403);
            echo "Acesso negado.";
            exit;
        }
    }
}
