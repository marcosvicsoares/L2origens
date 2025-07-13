<?php
namespace App\Models;

use App\Core\DB;

class Vote
{
    public static function canVote($account, $ip, $site)
    {
        $sql = "SELECT voted_at FROM vote_logs WHERE (account = ? OR ip_address = ?) AND site = ? ORDER BY voted_at DESC LIMIT 1";
        $result = DB::select($sql, [$account, $ip, $site]);

        if (!$result) return true;

        $lastVote = strtotime($result[0]['voted_at']);
        return (time() - $lastVote) >= 12 * 60 * 60; // 12 horas
    }

    public static function registerVote($account, $ip, $site)
    {
        $sql = "INSERT INTO vote_logs (account, ip_address, site) VALUES (?, ?, ?)";
        return DB::execute($sql, [$account, $ip, $site]);
    }
	public static function giveReward($account, $site)
{
    $rewardItemId = 57;       // Adena
    $rewardAmount = 1000000;  // 1kk por voto
    $description = "Vote site: " . $site;

    $sql = "INSERT INTO items_delayed (owner_id, item_id, count, description) 
            SELECT obj_id, ?, ?, ? FROM characters WHERE account_name = ? LIMIT 1";

    return DB::execute($sql, [$rewardItemId, $rewardAmount, $description, $account]);
}

}
