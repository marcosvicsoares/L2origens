<?php
namespace App\Models;

use App\Core\DB; // Certifique-se de que App\Core\DB está configurado corretamente

class Boss
{
    /**
     * Retorna todos os chefes épicos e seus status.
     * A coluna 'level' foi removida da seleção e ordenação, pois não existe na tabela 'epic_boss_status'.
     *
     * @return array
     */
    public static function getAll()
    {
        $sql = "
            SELECT
                boss_id,
                name,
                status,          -- O status atual do chefe ('alive' ou 'dead')
                respawn_time,    -- O timestamp do próximo respawn
                (respawn_time < UNIX_TIMESTAMP()) AS is_alive_by_respawn_time -- Verifica se o respawn_time já passou
            FROM
                epic_boss_status
            ORDER BY
                name ASC; -- Ordenando por nome, já que 'level' não existe
        ";
        // Nota: Use UNIX_TIMESTAMP() para comparar com respawn_time se este for um timestamp Unix.
        // Se respawn_time for um DATETIME, use NOW().

        return DB::select($sql);
    }

    // Você pode adicionar outros métodos para a classe Boss aqui, como:
    // public static function getBossById($bossId) { ... }
    // public static function updateBossStatus($bossId, $status, $respawnTime) { ... }
}
