<?php
namespace App\Models;

use PDO;
use App\Core\DB; // Usando a classe DB no namespace App\Core

class Shop
{
    /**
     * Retorna todos os itens da loja, incluindo seus nomes e preços, ordenados por preço.
     * A consulta agora seleciona 'item_name' diretamente da tabela 'shop_items'.
     *
     * @return array
     */
    public static function getAll()
    {
        // A consulta seleciona 'item_name' diretamente da tabela 'shop_items',
        // pois a sua nova estrutura de 'shop_items' inclui esta coluna.
        // Adicionei outras colunas que você definiu na sua CREATE TABLE para serem selecionadas.
        $sql = "
            SELECT
                id,          -- Chave primária da tabela shop_items
                item_id,     -- ID do item (referência ao item real do jogo)
                item_name,   -- O nome do item, agora na própria tabela shop_items
                price,       -- Preço do item
                description, -- Descrição do item
                category,    -- Categoria do item
                icon         -- Ícone do item
            FROM
                shop_items
            ORDER BY
                price ASC;
        ";

        // Assumimos que App\Core\DB::select() já executa a consulta e retorna os resultados como um array associativo.
        return DB::select($sql);
    }

    // Você pode adicionar outros métodos para a classe Shop aqui, como:
    // public static function getItemById($id) { ... }
    // public static function addItem($data) { ... }
    // public static function updateItem($id, $data) { ... }
    // public static function deleteItem($id) { ... }
}
