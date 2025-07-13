<?php
namespace App\Controllers;

use App\Models\Boss;
use App\Core\View; // Importa a classe View

class BossController
{
    public static function index()
    {
        $bosses = Boss::getAll(); // Assume que Boss::getAll() já retorna os dados necessários

        // Prepara os dados para a view
        $data = [
            'pageTitle' => 'Status dos Chefes Épicos',
            'bosses' => $bosses,
        ];

        // Renderiza a view 'bosses/index' usando o layout 'layout/site'
        // Assumimos que 'layout/site.php' é o layout principal para as páginas públicas.
        View::render('bosses/index', $data, 'layout/main'); // Alterado para 'layout/main' para consistência
    }
}
