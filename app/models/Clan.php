<?php
namespace App\Models;

use App\Core\DB;
use PDO;

class Clan
{
    /**
     * Encontra um clã pelo ID do clã.
     * @param int $clanId
     * @return array|null Dados do clã como array associativo, ou null se não encontrado.
     */
    public static function getById(int $clanId)
    {
        return DB::selectOne("SELECT * FROM clan_data WHERE clan_id = ?", [$clanId]);
    }

    /**
     * Encontra um clã pelo login da conta do líder.
     * Assume que a tabela `clan_data` tem uma coluna `leader_id` (que é o obj_Id do personagem líder)
     * e que a tabela `characters` tem `obj_Id` e `account_name`.
     *
     * @param string $accountLogin O login da conta do líder.
     * @return array|null Dados do clã (incluindo clan_level) se o líder for encontrado, caso contrário null.
     */
    public static function findByLeaderAccount(string $accountLogin)
    {
        $sql = "
            SELECT
                cd.*,
                -- Assumindo que 'clan_level' é a coluna para o nível do clã na tabela clan_data.
                -- Se for 'level', use cd.level.
                cd.clan_level
            FROM
                clan_data cd
            JOIN
                characters ch ON cd.leader_id = ch.obj_Id
            WHERE
                ch.account_name = ?
        ";
        return DB::selectOne($sql, [$accountLogin]);
    }

    // Você pode adicionar outros métodos para o modelo Clan aqui, se necessário.
}
