<?php
namespace App\Controllers;

use App\Models\Hero;
use App\Core\View; // Importa a classe View

class HeroController
{
    public static function index()
    {
        $heroes = Hero::getThisWeek(); // Assume que Hero::getThisWeek() já retorna os dados necessários

        // Prepara os dados para a view
        $data = [
            'pageTitle' => 'Heróis da Semana',
            'heroes' => $heroes,
        ];

        // Renderiza a view 'heroes/index' usando o layout principal do site
        View::render('heroes/index', $data, 'layout/main');
    }
}
