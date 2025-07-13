<?php
namespace App\Controllers;

use App\Middleware\AdminMiddleware;
use App\Core\DB;
use App\Core\View; // Importa a classe View

class AdminController
{
    public static function dashboard()
    {
        AdminMiddleware::check();

        $votos = DB::select("SELECT COUNT(*) AS total FROM vote_logs")[0]['total'];
        $doacoes = DB::select("SELECT COUNT(*) AS total FROM donate_logs")[0]['total'];

        // Prepara os dados para a view
        $data = [
            'pageTitle' => 'Painel Administrativo',
            'totalVotos' => $votos,
            'totalDoacoes' => $doacoes,
        ];

        // Renderiza a view 'admin/dashboard' usando o layout 'layout/admin'
        // Assumimos que você terá um layout específico para a área administrativa.
        View::render('admin/dashboard', $data, 'layout/admin');
    }
}
