<?php

namespace App\Controllers;

use App\Models\BattlePassModel; // Você precisará criar este Model

class AdminBattlePassController {
    public static function index() {
        // Lógica para obter a lista de Battle Passes
        // $battlePasses = BattlePassModel::getAll(); 

        // Simulação de dados para o exemplo
        $battlePasses = [
            ['id' => 1, 'nome' => 'Passe de Batalha Temporada 1', 'ativo' => true],
            ['id' => 2, 'nome' => 'Passe de Batalha Temporada 2', 'ativo' => false],
        ];

        // A view 'battlepass.php' terá acesso à variável $battlePasses
        $view = __DIR__ . '/../views/admin/battlepass.php';
        include __DIR__ . '/../views/layouts/admin.php'; // Ou o layout que você usa para o painel
    }

    public static function create() {
        // Lógica para criar um novo Battle Pass (processar formulário)
    }

    public static function edit($id) {
        // Lógica para editar um Battle Pass
    }
}