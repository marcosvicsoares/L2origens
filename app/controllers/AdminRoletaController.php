<?php

namespace App\Controllers;

use App\Models\RoletaModel;
use App\Core\View; // Assumindo que você tem uma classe View para renderização

class AdminRoletaController
{
    private $roletaModel;

    public function __construct()
    {
        $this->roletaModel = new RoletaModel();
    }

    /**
     * Exibe a lista de todos os itens da roleta.
     */
    public function index()
    {
        $itensRoleta = $this->roletaModel->getAll();
        View::render('admin/roleta/index', ['itensRoleta' => $itensRoleta], 'layouts/admin');
    }

    /**
     * Exibe o formulário para criar um novo item da roleta.
     */
    public function createForm()
    {
        View::render('admin/roleta/form', ['item' => null, 'pageTitle' => 'Criar Novo Item da Roleta'], 'layouts/admin');
    }

    /**
     * Processa a submissão do formulário para criar um novo item da roleta.
     */
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nome' => filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING),
                'descricao' => filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING),
                'probabilidade' => filter_input(INPUT_POST, 'probabilidade', FILTER_VALIDATE_INT),
                'item_id' => filter_input(INPUT_POST, 'item_id', FILTER_VALIDATE_INT),
                'quantidade' => filter_input(INPUT_POST, 'quantidade', FILTER_VALIDATE_INT),
                'imagem' => filter_input(INPUT_POST, 'imagem', FILTER_SANITIZE_URL),
            ];

            // Validação básica
            if (empty($data['nome']) || $data['probabilidade'] === false || $data['probabilidade'] < 0) {
                // Redirecionar com mensagem de erro
                header('Location: /admin/roleta/create?error=invalid_data');
                return;
            }

            if ($this->roletaModel->create($data)) {
                header('Location: /admin/roleta?success=created');
            } else {
                header('Location: /admin/roleta/create?error=db_error');
            }
            return;
        }
        // Se não for POST, redireciona para o formulário
        header('Location: /admin/roleta/create');
    }

    /**
     * Exibe o formulário para editar um item da roleta existente.
     * @param int $id O ID do item a ser editado.
     */
    public function editForm($id)
    {
        $item = $this->roletaModel->getById($id);
        if (!$item) {
            header('Location: /admin/roleta?error=not_found');
            return;
        }
        View::render('admin/roleta/form', ['item' => $item, 'pageTitle' => 'Editar Item da Roleta'], 'layouts/admin');
    }

    /**
     * Processa a submissão do formulário para atualizar um item da roleta.
     * @param int $id O ID do item a ser atualizado.
     */
    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nome' => filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING),
                'descricao' => filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING),
                'probabilidade' => filter_input(INPUT_POST, 'probabilidade', FILTER_VALIDATE_INT),
                'item_id' => filter_input(INPUT_POST, 'item_id', FILTER_VALIDATE_INT),
                'quantidade' => filter_input(INPUT_POST, 'quantidade', FILTER_VALIDATE_INT),
                'imagem' => filter_input(INPUT_POST, 'imagem', FILTER_SANITIZE_URL),
            ];

            // Validação básica
            if (empty($data['nome']) || $data['probabilidade'] === false || $data['probabilidade'] < 0) {
                header('Location: /admin/roleta/edit/' . $id . '?error=invalid_data');
                return;
            }

            if ($this->roletaModel->update($id, $data)) {
                header('Location: /admin/roleta?success=updated');
            } else {
                header('Location: /admin/roleta/edit/' . $id . '?error=db_error');
            }
            return;
        }
        // Se não for POST, redireciona para o formulário
        header('Location: /admin/roleta/edit/' . $id);
    }

    /**
     * Exclui um item da roleta.
     * @param int $id O ID do item a ser excluído.
     */
    public function delete($id)
    {
        // Em uma aplicação real, você pode querer confirmar a exclusão via POST ou um modal.
        // Para simplificar, estamos permitindo DELETE via GET aqui.
        if ($this->roletaModel->delete($id)) {
            header('Location: /admin/roleta?success=deleted');
        } else {
            header('Location: /admin/roleta?error=db_error');
        }
        return;
    }
}
