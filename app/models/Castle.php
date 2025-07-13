<?php
namespace App\Models;

use App\Core\DB;

class Castle
{
    public static function getAllWithOwners()
    {
        $sql = "
            SELECT
                c.name,
                cl.clan_name,
                FROM_UNIXTIME(c.siegeDate / 1000) AS siege_date
            FROM castle c
            LEFT JOIN clan_data cl ON c.id = cl.hasCastle; -- CORRIGIDO: O JOIN agora usa 'c.id' e 'cl.hasCastle'
            -- 'c.id' é o ID do castelo na tabela 'castle'.
            -- 'cl.hasCastle' é o ID do castelo que o clã possui na tabela 'clan_data'.
            -- Se a coluna de ID do castelo na sua tabela 'castle' não for 'id',
            -- você precisará substituí-la (ex: 'c.castle_id').
        ";
        return DB::select($sql);
    }
}
