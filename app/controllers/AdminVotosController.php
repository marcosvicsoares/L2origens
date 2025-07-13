<?php
namespace App\Controllers;

use App\Middleware\AdminMiddleware;
use App\Core\DB;
use App\Core\View; // Importa a classe View

class AdminVotosController
{
    public static function index()
    {
        AdminMiddleware::check();
        $votos = DB::select("SELECT * FROM vote_logs ORDER BY voted_at DESC LIMIT 100");

        // Prepara os dados para a view
        $data = [
            'pageTitle' => 'Registros de Votos',
            'votos' => $votos,
        ];

        // Renderiza a view 'admin/votos' usando o layout 'layout/admin'
        View::render('admin/votos', $data, 'layout/admin');
    }
}
