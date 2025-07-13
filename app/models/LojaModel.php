<?php

namespace App\Models;

use App\Core\Database; // Assumindo que você tem uma classe Database para conexão

class LojaModel
{
    private $db;
    private $table = 'loja_itens'; // Nome da sua tabela no banco de dados

    public function __construct()
    {
        $this->db = Database::getInstance(); // Obtém a instância da conexão com o banco de dados
    }

    /**
     * Obtém todos os itens da loja do banco de dados.
     * @return array Uma lista de itens da loja.
     */
    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM {$this->table} ORDER BY id DESC");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Obtém um item da loja pelo seu ID.
     * @param int $id O ID do item da loja.
     * @return array|null O item da loja ou null se não encontrado.
     */
    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Cria um novo item na loja.
     * @param array $data Os dados do item (nome, descricao, preco, etc.).
     * @return bool True se o item foi criado com sucesso, false caso contrário.
     */
    public function create($data)
    {
        $stmt = $this->db->prepare("INSERT INTO {$this->table} (nome, descricao, preco, item_id, quantidade, categoria, imagem, status) VALUES (:nome, :descricao, :preco, :item_id, :quantidade, :categoria, :imagem, :status)");
        
        $stmt->bindParam(':nome', $data['nome']);
        $stmt->bindParam(':descricao', $data['descricao']);
        $stmt->bindParam(':preco', $data['preco']); // Preço pode ser float/decimal
        $stmt->bindParam(':item_id', $data['item_id'], \PDO::PARAM_INT);
        $stmt->bindParam(':quantidade', $data['quantidade'], \PDO::PARAM_INT);
        $stmt->bindParam(':categoria', $data['categoria']);
        $stmt->bindParam(':imagem', $data['imagem']);
        $stmt->bindParam(':status', $data['status']);

        return $stmt->execute();
    }

    /**
     * Atualiza um item da loja existente.
     * @param int $id O ID do item a ser atualizado.
     * @param array $data Os novos dados do item.
     * @return bool True se o item foi atualizado com sucesso, false caso contrário.
     */
    public function update($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET nome = :nome, descricao = :descricao, preco = :preco, item_id = :item_id, quantidade = :quantidade, categoria = :categoria, imagem = :imagem, status = :status WHERE id = :id");
        
        $stmt->bindParam(':nome', $data['nome']);
        $stmt->bindParam(':descricao', $data['descricao']);
        $stmt->bindParam(':preco', $data['preco']);
        $stmt->bindParam(':item_id', $data['item_id'], \PDO::PARAM_INT);
        $stmt->bindParam(':quantidade', $data['quantidade'], \PDO::PARAM_INT);
        $stmt->bindParam(':categoria', $data['categoria']);
        $stmt->bindParam(':imagem', $data['imagem']);
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Exclui um item da loja.
     * @param int $id O ID do item a ser excluído.
     * @return bool True se o item foi excluído com sucesso, false caso contrário.
     */
    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        return $stmt->execute();
    }
}
