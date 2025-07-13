<?php
namespace App\Models;

use PDO;
use App\Database;

class BattlePass
{
    public static function getTiersForMonth($month)
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM battlepass_tiers WHERE month = ?");
        $stmt->execute([$month]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getProgress($charId, $month)
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT tier_id, progress FROM battlepass_progress WHERE char_id = ? AND month = ?");
        $stmt->execute([$charId, $month]);
        $result = [];
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $result[$row['tier_id']] = $row['progress'];
        }
        return $result;
    }

    public static function getClaimedRewards($charId, $month)
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT tier_id FROM battlepass_claims WHERE char_id = ? AND month = ?");
        $stmt->execute([$charId, $month]);
        return array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'tier_id');
    }

    public static function isTierCompleted($charId, $tierId, $month)
    {
        $progress = self::getProgress($charId, $month);
        return isset($progress[$tierId]) && $progress[$tierId] >= 100;
    }

    public static function hasAlreadyClaimed($charId, $tierId, $month)
    {
        $claimed = self::getClaimedRewards($charId, $month);
        return in_array($tierId, $claimed);
    }

    public static function getReward($tierId)
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM battlepass_tiers WHERE id = ?");
        $stmt->execute([$tierId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function grantReward($charId, $reward)
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO items (owner_id, item_id, count, enchant_level) VALUES (?, ?, ?, ?)");
        $stmt->execute([$charId, $reward['item_id'], $reward['amount'], $reward['enchant'] ?? 0]);
    }

    public static function markAsClaimed($charId, $tierId, $month)
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO battlepass_claims (char_id, tier_id, month) VALUES (?, ?, ?)");
        $stmt->execute([$charId, $tierId, $month]);
    }
}
