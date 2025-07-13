<?php

namespace App\Models;

use App\Core\Database; // Assumindo que você tem uma classe Database para conexão

class RoletaModel
{
    private $db;
    private $table = 'roleta_itens'; // Nome da sua tabela no banco de dados

    public function __construct()
    {
        $this->db = Database::getInstance(); // Obtém a instância da conexão com o banco de dados
    }

    /**
     * Obtém todos os itens da roleta do banco de dados.
     * @return array Uma lista de itens da roleta.
     */
    public function getAll()
    {
        // Exemplo de consulta SQL para obter todos os itens
        $stmt = $this->db->query("SELECT * FROM {$this->table} ORDER BY id DESC");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Obtém um item da roleta pelo seu ID.
     * @param int $id O ID do item da roleta.
     * @return array|null O item da roleta ou null se não encontrado.
     */
    public function getById($id)
    {
        // Exemplo de consulta SQL para obter um item por ID
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Cria um novo item na roleta.
     * @param array $data Os dados do item (nome, probabilidade, etc.).
     * @return bool True se o item foi criado com sucesso, false caso contrário.
     */
    public function create($data)
    {
        // Exemplo de inserção SQL. Ajuste os campos conforme sua tabela.
        $stmt = $this->db->prepare("INSERT INTO {$this->table} (nome, descricao, probabilidade, item_id, quantidade, imagem) VALUES (:nome, :descricao, :probabilidade, :item_id, :quantidade, :imagem)");
        
        $stmt->bindParam(':nome', $data['nome']);
        $stmt->bindParam(':descricao', $data['descricao']);
        $stmt->bindParam(':probabilidade', $data['probabilidade'], \PDO::PARAM_INT);
        $stmt->bindParam(':item_id', $data['item_id'], \PDO::PARAM_INT);
        $stmt->bindParam(':quantidade', $data['quantidade'], \PDO::PARAM_INT);
        $stmt->bindParam(':imagem', $data['imagem']);

        return $stmt->execute();
    }

    /**
     * Atualiza um item da roleta existente.
     * @param int $id O ID do item a ser atualizado.
     * @param array $data Os novos dados do item.
     * @return bool True se o item foi atualizado com sucesso, false caso contrário.
     */
    public function update($id, $data)
    {
        // Exemplo de atualização SQL. Ajuste os campos conforme sua tabela.
        $stmt = $this->db->prepare("UPDATE {$this->table} SET nome = :nome, descricao = :descricao, probabilidade = :probabilidade, item_id = :item_id, quantidade = :quantidade, imagem = :imagem WHERE id = :id");
        
        $stmt->bindParam(':nome', $data['nome']);
        $stmt->bindParam(':descricao', $data['descricao']);
        $stmt->bindParam(':probabilidade', $data['probabilidade'], \PDO::PARAM_INT);
        $stmt->bindParam(':item_id', $data['item_id'], \PDO::PARAM_INT);
        $stmt->bindParam(':quantidade', $data['quantidade'], \PDO::PARAM_INT);
        $stmt->bindParam(':imagem', $data['imagem']);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Exclui um item da roleta.
     * @param int $id O ID do item a ser excluído.
     * @return bool True se o item foi excluído com sucesso, false caso contrário.
     */
    public function delete($id)
    {
        // Exemplo de exclusão SQL
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        return $stmt->execute();
    }
}
