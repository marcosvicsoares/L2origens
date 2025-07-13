<?php
namespace App\Middleware;

class AuthMiddleware
{
    public static function check()
    {
        session_start();
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit;
        }
    }
}
