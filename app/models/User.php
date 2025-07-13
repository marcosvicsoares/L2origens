<?php
namespace App\Models;

use PDO;
use App\Database;

class User
{
    /**
     * Busca um usuário pelo login
     * @param string $login
     * @return array|null
     */
    public static function findByLogin($login)
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT login, password, accessLevel FROM accounts WHERE login = ?");
        $stmt->execute([$login]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Cria uma nova conta no servidor
     * @param string $login
     * @param string $password
     * @param string $email
     * @return bool
     */
    public static function create($login, $password, $email = '')
    {
        $db = Database::getConnection();

        // Verifica se já existe
        if (self::findByLogin($login)) {
            return false;
        }

        // Escolhe criptografia
        $encrypted = match (PASSWORD_ENCRYPTION ?? 'none') {
            'md5' => md5($password),
            'sha1' => sha1($password),
            default => $password
        };

        $stmt = $db->prepare("INSERT INTO accounts (login, password, email, accessLevel, lastactive) VALUES (?, ?, ?, 0, NOW())");
        return $stmt->execute([$login, $encrypted, $email]);
    }

    /**
     * Atualiza a senha de um usuário
     * @param string $login
     * @param string $newPassword
     * @return bool
     */
    public static function updatePassword($login, $newPassword)
    {
        $db = Database::getConnection();

        $encrypted = match (PASSWORD_ENCRYPTION ?? 'none') {
            'md5' => md5($newPassword),
            'sha1' => sha1($newPassword),
            default => $newPassword
        };

        $stmt = $db->prepare("UPDATE accounts SET password = ? WHERE login = ?");
        return $stmt->execute([$encrypted, $login]);
    }

    /**
     * Retorna o número total de contas registradas
     * @return int
     */
    public static function count()
    {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT COUNT(*) FROM accounts");
        return (int) $stmt->fetchColumn();
    }
}
