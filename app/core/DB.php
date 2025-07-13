<?php

namespace App\Core;

use PDO;
use PDOException;

class DB
{
    private static $pdo; // Renomeado de $connection para $pdo

    /**
     * Estabelece e retorna a conexão PDO com o banco de dados.
     * Utiliza variáveis de ambiente para as credenciais.
     * @return PDO
     */
    public static function connect()
    {
        if (!self::$pdo) { // Verifica se a conexão já existe
            try {
                // Obtém as configurações do banco de dados diretamente de variáveis de ambiente.
                // É CRUCIAL que estas variáveis de ambiente estejam definidas no seu ambiente de execução!
                $host = $_ENV['DB_HOST'] ?? 'seuhost';
                $db   = $_ENV['DB_DATABASE'] ?? 'suadatabase';
                $user = $_ENV['DB_USERNAME'] ?? 'seuroot';
                $pass = $_ENV['DB_PASSWORD'] ?? 'suasenha';
                $charset = 'utf8mb4';

                $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
                $options = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Lança PDOExceptions em caso de erro
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Define o modo de busca padrão para arrays associativos
                    PDO::ATTR_EMULATE_PREPARES   => false,                  // Desabilita a emulação de prepared statements para segurança e desempenho
                ];

                self::$pdo = new PDO($dsn, $user, $pass, $options);
            } catch (PDOException $e) {
                // Em um ambiente de produção, você pode logar o erro
                // e mostrar uma mensagem mais amigável ao usuário.
                die("Erro ao conectar ao banco de dados: " . $e->getMessage() . 
                    ". Verifique se as variáveis de ambiente DB_HOST, DB_DATABASE, DB_USERNAME e DB_PASSWORD estão configuradas.");
            }
        }

        return self::$pdo;
    }

    /**
     * Executa uma consulta SELECT e retorna todos os resultados.
     * @param string $sql A consulta SQL.
     * @param array $params Parâmetros para a consulta preparada (opcional).
     * @return array Os resultados da consulta como um array associativo.
     */
    public static function select($sql, $params = [])
    {
        $stmt = self::connect()->prepare($sql); // Usa o método connect()
        $stmt->execute($params);
        return $stmt->fetchAll(); // Retorna todos os resultados
    }

    /**
     * Executa uma consulta SELECT e retorna apenas uma única linha.
     * @param string $sql A consulta SQL.
     * @param array $params Parâmetros para a consulta preparada (opcional).
     * @return array|null A linha do resultado como um array associativo, ou null se não for encontrada.
     */
    public static function selectOne($sql, $params = [])
    {
        $stmt = self::connect()->prepare($sql); // Usa o método connect()
        $stmt->execute($params);
        return $stmt->fetch(); // Usa fetch() para uma única linha
    }

    /**
     * Executa uma consulta SQL que não retorna resultados (INSERT, UPDATE, DELETE, etc.).
     * @param string $sql A consulta SQL.
     * @param array $params Parâmetros para a consulta preparada (opcional).
     * @return bool True em caso de sucesso, false em caso de falha.
     */
    public static function execute($sql, $params = [])
    {
        $stmt = self::connect()->prepare($sql); // Usa o método connect()
        return $stmt->execute($params);
    }
}
