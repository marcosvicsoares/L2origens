<?php
namespace App\Models;

use App\Core\DB;

class Character
{
    /**
     * Retorna todos os personagens de uma conta
     */
    public static function getByAccount(string $login): array
    {
        $sql = "SELECT obj_Id, char_name, level, classid, online FROM characters WHERE account_name = ?";
        return DB::select($sql, [$login]);
    }

    /**
     * Retorna um personagem pelo nome
     */
    public static function findByName(string $name): ?array
    {
        $sql = "SELECT * FROM characters WHERE char_name = ?";
        return DB::selectOne($sql, [$name]);
    }

    /**
     * Retorna um personagem pelo ID
     */
    public static function findById(int $id): ?array
    {
        $sql = "SELECT * FROM characters WHERE obj_Id = ?";
        return DB::selectOne($sql, [$id]);
    }

    /**
     * Verifica se personagem pertence à conta
     */
    public static function belongsToAccount(int $charId, string $login): bool
    {
        $sql = "SELECT 1 FROM characters WHERE obj_Id = ? AND account_name = ?";
        return (bool) DB::scalar($sql, [$charId, $login]);
    }

    /**
     * Retorna o nome da classe baseado no classid para crônicas Interlude.
     */
    public static function getClassName(int $classid): string
    {
        $classes = [
            // Human Fighter
            0 => 'Fighter', 1 => 'Warrior', 2 => 'Gladiator', 3 => 'Warlord',
            4 => 'Knight', 5 => 'Paladin', 6 => 'Dark Avenger', 7 => 'Rogue',
            8 => 'Treasure Hunter', 9 => 'Hawkeye',
            // Human Mystic
            10 => 'Human Mystic', 11 => 'Human Wizard', 12 => 'Sorcerer',
            13 => 'Necromancer', 14 => 'Warlock', 15 => 'Cleric',
            16 => 'Bishop', 17 => 'Prophet',
            // Elf Fighter
            18 => 'Elven Fighter', 19 => 'Elven Knight', 20 => 'Temple Knight',
            21 => 'Swordsinger', 22 => 'Elven Scout', 23 => 'Plainswalker',
            24 => 'Silver Ranger',
            // Elf Mystic
            25 => 'Elven Mystic', 26 => 'Elven Wizard', 27 => 'Spellsinger',
            28 => 'Elemental Summoner', 29 => 'Elven Oracle', 30 => 'Elven Elder',
            // Dark Elf Fighter
            31 => 'Dark Fighter', 32 => 'Palus Knight', 33 => 'Shillien Knight',
            34 => 'Bladedancer', 35 => 'Assassin', 36 => 'Abyss Walker',
            37 => 'Phantom Ranger',
            // Dark Elf Mystic
            38 => 'Dark Mystic', 39 => 'Dark Wizard', 40 => 'Spellhowler',
            41 => 'Phantom Summoner', 42 => 'Shillien Oracle', 43 => 'Shillien Elder',
            // Orc Fighter
            44 => 'Orc Fighter', 45 => 'Orc Raider', 46 => 'Destroyer', 47 => 'Tyrant',
            // Orc Mystic
            48 => 'Orc Mystic', 49 => 'Orc Shaman', 50 => 'Overlord', 51 => 'Warcryer',
            // Dwarf
            52 => 'Dwarf Fighter', 53 => 'Scavenger', 54 => 'Bounty Hunter',
            55 => 'Artisan', 56 => 'Warsmith'
        ];
        return $classes[$classid] ?? 'Desconhecida';
    }

    /**
     * Retorna os 50 jogadores com mais PvP Kills
     */
    public static function getTopPlayers(int $limit = 50): array
    {
        $sql = "
            SELECT char_name, level, pvpkills, pkkills, online
            FROM characters
            WHERE accesslevel = 0
            ORDER BY pvpkills DESC
            LIMIT ?
        ";
        return DB::select($sql, [$limit]);
    }
}
