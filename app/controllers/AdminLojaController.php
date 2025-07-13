<?php

namespace App\Controllers;

use App\Models\LojaModel;
use App\Core\View; // Assumindo que você tem uma classe View para renderização

class AdminLojaController
{
    private $lojaModel;

    public function __construct()
    {
        $this->lojaModel = new LojaModel();
    }

    /**
     * Exibe a lista de todos os itens da loja.
     */
    public function index()
    {
        $itensLoja = $this->lojaModel->getAll();
        View::render('admin/loja/index', ['itensLoja' => $itensLoja, 'pageTitle' => 'Gerenciar Loja'], 'layouts/admin');
    }

    /**
     * Exibe o formulário para criar um novo item da loja.
     */
    public function createForm()
    {
        View::render('admin/loja/form', ['item' => null, 'pageTitle' => 'Adicionar Novo Item na Loja'], 'layouts/admin');
    }

    /**
     * Processa a submissão do formulário para criar um novo item da loja.
     */
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nome' => filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING),
                'descricao' => filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING),
                'preco' => filter_input(INPUT_POST, 'preco', FILTER_VALIDATE_FLOAT),
                'item_id' => filter_input(INPUT_POST, 'item_id', FILTER_VALIDATE_INT),
                'quantidade' => filter_input(INPUT_POST, 'quantidade', FILTER_VALIDATE_INT),
                'categoria' => filter_input(INPUT_POST, 'categoria', FILTER_SANITIZE_STRING),
                'imagem' => filter_input(INPUT_POST, 'imagem', FILTER_SANITIZE_URL),
                'status' => filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING),
            ];

            // Validação básica
            if (empty($data['nome']) || $data['preco'] === false || $data['preco'] < 0) {
                header('Location: /admin/loja/create?error=invalid_data');
                return;
            }

            if ($this->lojaModel->create($data)) {
                header('Location: /admin/loja?success=created');
            } else {
                header('Location: /admin/loja/create?error=db_error');
            }
            return;
        }
        header('Location: /admin/loja/create');
    }

    /**
     * Exibe o formulário para editar um item da loja existente.
     * @param int $id O ID do item a ser editado.
     */
    public function editForm($id)
    {
        $item = $this->lojaModel->getById($id);
        if (!$item) {
            header('Location: /admin/loja?error=not_found');
            return;
        }
        View::render('admin/loja/form', ['item' => $item, 'pageTitle' => 'Editar Item da Loja'], 'layouts/admin');
    }

    /**
     * Processa a submissão do formulário para atualizar um item da loja.
     * @param int $id O ID do item a ser atualizado.
     */
    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nome' => filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING),
                'descricao' => filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING),
                'preco' => filter_input(INPUT_POST, 'preco', FILTER_VALIDATE_FLOAT),
                'item_id' => filter_input(INPUT_POST, 'item_id', FILTER_VALIDATE_INT),
                'quantidade' => filter_input(INPUT_POST, 'quantidade', FILTER_VALIDATE_INT),
                'categoria' => filter_input(INPUT_POST, 'categoria', FILTER_SANITIZE_STRING),
                'imagem' => filter_input(INPUT_POST, 'imagem', FILTER_SANITIZE_URL),
                'status' => filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING),
            ];

            // Validação básica
            if (empty($data['nome']) || $data['preco'] === false || $data['preco'] < 0) {
                header('Location: /admin/loja/edit/' . $id . '?error=invalid_data');
                return;
            }

            if ($this->lojaModel->update($id, $data)) {
                header('Location: /admin/loja?success=updated');
            } else {
                header('Location: /admin/loja/edit/' . $id . '?error=db_error');
            }
            return;
        }
        header('Location: /admin/loja/edit/' . $id);
    }

    /**
     * Exclui um item da loja.
     * @param int $id O ID do item a ser excluído.
     */
    public function delete($id)
    {
        // Em uma aplicação real, considere usar POST para exclusão e/ou um modal de confirmação.
        if ($this->lojaModel->delete($id)) {
            header('Location: /admin/loja?success=deleted');
        } else {
            header('Location: /admin/loja?error=db_error');
        }
        return;
    }
}
