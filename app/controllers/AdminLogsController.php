<?php
namespace App\Controllers;

use App\Middleware\AdminMiddleware;
use App\Core\DB;
use App\Core\View; // Importa a classe View

class AdminLogsController
{
    public static function index()
    {
        AdminMiddleware::check();
        $logs = DB::select("SELECT * FROM admin_logs ORDER BY created_at DESC LIMIT 100");

        // Prepara os dados para a view
        $data = [
            'pageTitle' => 'Logs Administrativos',
            'logs' => $logs,
        ];

        // Renderiza a view 'admin/logs' usando o layout 'layout/admin'
        View::render('admin/logs', $data, 'layout/admin');
    }
}
