<?php

namespace App\Controllers;

use App\Models\SiegeModel;
use App\Core\View; // Assumindo que você tem uma classe View para renderização

class AdminSiegeController
{
    private $siegeModel;

    public function __construct()
    {
        $this->siegeModel = new SiegeModel();
    }

    /**
     * Exibe a lista de todos os eventos de siege.
     */
    public function index()
    {
        $sieges = $this->siegeModel->getAll();
        View::render('admin/sieges/index', ['sieges' => $sieges, 'pageTitle' => 'Gerenciar Sieges'], 'layouts/admin');
    }

    /**
     * Exibe o formulário para criar um novo evento de siege.
     */
    public function createForm()
    {
        View::render('admin/sieges/form', ['siege' => null, 'pageTitle' => 'Criar Nova Siege'], 'layouts/admin');
    }

    /**
     * Processa a submissão do formulário para criar um novo evento de siege.
     */
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nome' => filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING),
                'data_inicio' => filter_input(INPUT_POST, 'data_inicio', FILTER_SANITIZE_STRING),
                'data_fim' => filter_input(INPUT_POST, 'data_fim', FILTER_SANITIZE_STRING),
                'recompensas' => filter_input(INPUT_POST, 'recompensas', FILTER_SANITIZE_STRING), // Pode ser JSON
                'status' => filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING),
                'localizacao' => filter_input(INPUT_POST, 'localizacao', FILTER_SANITIZE_STRING),
                'min_players' => filter_input(INPUT_POST, 'min_players', FILTER_VALIDATE_INT),
                'max_players' => filter_input(INPUT_POST, 'max_players', FILTER_VALIDATE_INT),
            ];

            // Validação básica
            if (empty($data['nome']) || empty($data['data_inicio']) || empty($data['data_fim']) || empty($data['status'])) {
                header('Location: /admin/sieges/create?error=invalid_data');
                return;
            }

            if ($this->siegeModel->create($data)) {
                header('Location: /admin/sieges?success=created');
            } else {
                header('Location: /admin/sieges/create?error=db_error');
            }
            return;
        }
        header('Location: /admin/sieges/create');
    }

    /**
     * Exibe o formulário para editar um evento de siege existente.
     * @param int $id O ID do evento a ser editado.
     */
    public function editForm($id)
    {
        $siege = $this->siegeModel->getById($id);
        if (!$siege) {
            header('Location: /admin/sieges?error=not_found');
            return;
        }
        View::render('admin/sieges/form', ['siege' => $siege, 'pageTitle' => 'Editar Siege'], 'layouts/admin');
    }

    /**
     * Processa a submissão do formulário para atualizar um evento de siege.
     * @param int $id O ID do evento a ser atualizado.
     */
    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nome' => filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING),
                'data_inicio' => filter_input(INPUT_POST, 'data_inicio', FILTER_SANITIZE_STRING),
                'data_fim' => filter_input(INPUT_POST, 'data_fim', FILTER_SANITIZE_STRING),
                'recompensas' => filter_input(INPUT_POST, 'recompensas', FILTER_SANITIZE_STRING),
                'status' => filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING),
                'localizacao' => filter_input(INPUT_POST, 'localizacao', FILTER_SANITIZE_STRING),
                'min_players' => filter_input(INPUT_POST, 'min_players', FILTER_VALIDATE_INT),
                'max_players' => filter_input(INPUT_POST, 'max_players', FILTER_VALIDATE_INT),
            ];

            // Validação básica
            if (empty($data['nome']) || empty($data['data_inicio']) || empty($data['data_fim']) || empty($data['status'])) {
                header('Location: /admin/sieges/edit/' . $id . '?error=invalid_data');
                return;
            }

            if ($this->siegeModel->update($id, $data)) {
                header('Location: /admin/sieges?success=updated');
            } else {
                header('Location: /admin/sieges/edit/' . $id . '?error=db_error');
            }
            return;
        }
        header('Location: /admin/sieges/edit/' . $id);
    }

    /**
     * Exclui um evento de siege.
     * @param int $id O ID do evento a ser excluído.
     */
    public function delete($id)
    {
        // Em uma aplicação real, considere usar POST para exclusão e/ou um modal de confirmação.
        if ($this->siegeModel->delete($id)) {
            header('Location: /admin/sieges?success=deleted');
        } else {
            header('Location: /admin/sieges?error=db_error');
        }
        return;
    }
}
