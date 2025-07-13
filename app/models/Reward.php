<?php
namespace App\Models;

use PDO;
use App\Database;

class Reward
{
    /**
     * Envia um item para o personagem
     * @param int $charId - ID do personagem (owner_id na tabela items)
     * @param int $itemId - ID do item
     * @param int $amount - Quantidade
     * @param int $enchant - Encantamento (opcional)
     */
    public static function giveItem($charId, $itemId, $amount = 1, $enchant = 0)
    {
        $db = Database::getConnection();

        // Verifica se o personagem já tem o item (stackável)
        $stmt = $db->prepare("SELECT object_id, count FROM items WHERE owner_id = ? AND item_id = ? AND enchant_level = ?");
        $stmt->execute([$charId, $itemId, $enchant]);
        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($item) {
            // Atualiza quantidade
            $stmt = $db->prepare("UPDATE items SET count = count + ? WHERE object_id = ?");
            $stmt->execute([$amount, $item['object_id']]);
        } else {
            // Insere novo item
            $stmt = $db->prepare("INSERT INTO items (owner_id, item_id, count, enchant_level) VALUES (?, ?, ?, ?)");
            $stmt->execute([$charId, $itemId, $amount, $enchant]);
        }
    }

    /**
     * Remove um item do personagem
     * @param int $charId
     * @param int $itemId
     * @param int $amount
     * @return bool
     */
    public static function removeItem($charId, $itemId, $amount)
    {
        $db = Database::getConnection();

        // Verifica se tem item suficiente
        $stmt = $db->prepare("SELECT object_id, count FROM items WHERE owner_id = ? AND item_id = ?");
        $stmt->execute([$charId, $itemId]);
        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$item || $item['count'] < $amount) {
            return false;
        }

        // Atualiza ou remove item
        if ($item['count'] == $amount) {
            $stmt = $db->prepare("DELETE FROM items WHERE object_id = ?");
            $stmt->execute([$item['object_id']]);
        } else {
            $stmt = $db->prepare("UPDATE items SET count = count - ? WHERE object_id = ?");
            $stmt->execute([$amount, $item['object_id']]);
        }

        return true;
    }
}
