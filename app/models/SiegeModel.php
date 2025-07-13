<?php

namespace App\Models;

use App\Core\Database; // Assumindo que você tem uma classe Database para conexão

class SiegeModel
{
    private $db;
    private $table = 'sieges'; // Nome da sua tabela no banco de dados

    public function __construct()
    {
        $this->db = Database::getInstance(); // Obtém a instância da conexão com o banco de dados
    }

    /**
     * Obtém todos os eventos de siege do banco de dados.
     * @return array Uma lista de eventos de siege.
     */
    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM {$this->table} ORDER BY data_inicio DESC");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Obtém um evento de siege pelo seu ID.
     * @param int $id O ID do evento de siege.
     * @return array|null O evento de siege ou null se não encontrado.
     */
    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Cria um novo evento de siege.
     * @param array $data Os dados do evento (nome, data_inicio, data_fim, etc.).
     * @return bool True se o evento foi criado com sucesso, false caso contrário.
     */
    public function create($data)
    {
        $stmt = $this->db->prepare("INSERT INTO {$this->table} (nome, data_inicio, data_fim, recompensas, status, localizacao, min_players, max_players) VALUES (:nome, :data_inicio, :data_fim, :recompensas, :status, :localizacao, :min_players, :max_players)");
        
        $stmt->bindParam(':nome', $data['nome']);
        $stmt->bindParam(':data_inicio', $data['data_inicio']);
        $stmt->bindParam(':data_fim', $data['data_fim']);
        $stmt->bindParam(':recompensas', $data['recompensas']); // Pode ser JSON string
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':localizacao', $data['localizacao']);
        $stmt->bindParam(':min_players', $data['min_players'], \PDO::PARAM_INT);
        $stmt->bindParam(':max_players', $data['max_players'], \PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Atualiza um evento de siege existente.
     * @param int $id O ID do evento a ser atualizado.
     * @param array $data Os novos dados do evento.
     * @return bool True se o evento foi atualizado com sucesso, false caso contrário.
     */
    public function update($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET nome = :nome, data_inicio = :data_inicio, data_fim = :data_fim, recompensas = :recompensas, status = :status, localizacao = :localizacao, min_players = :min_players, max_players = :max_players WHERE id = :id");
        
        $stmt->bindParam(':nome', $data['nome']);
        $stmt->bindParam(':data_inicio', $data['data_inicio']);
        $stmt->bindParam(':data_fim', $data['data_fim']);
        $stmt->bindParam(':recompensas', $data['recompensas']); // Pode ser JSON string
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':localizacao', $data['localizacao']);
        $stmt->bindParam(':min_players', $data['min_players'], \PDO::PARAM_INT);
        $stmt->bindParam(':max_players', $data['max_players'], \PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Exclui um evento de siege.
     * @param int $id O ID do evento a ser excluído.
     * @return bool True se o evento foi excluído com sucesso, false caso contrário.
     */
    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        return $stmt->execute();
    }
}
