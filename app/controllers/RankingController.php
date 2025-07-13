<?php
namespace App\Controllers;

use App\Models\Character;
use App\Core\View; // Importa a classe View

class RankingController
{
    public static function index()
    {
        $players = Character::getTopPlayers(); // Assume que Character::getTopPlayers() já retorna os dados necessários

        // Prepara os dados para a view
        $data = [
            'pageTitle' => 'Ranking de Jogadores',
            'players' => $players,
        ];

        // Renderiza a view 'ranking/index' usando o layout principal do site
        View::render('ranking/index', $data, 'layout/main');
    }
}
