<?php
namespace App\Models;

use App\Core\DB;

class Hero
{
    public static function getThisWeek()
    {
        $sql = "SELECT char_id, class_id FROM heroes ORDER BY char_id";
        return DB::select($sql);
    }
}
