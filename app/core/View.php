<?php

namespace App\Core;

class View
{
    /**
     * Renderiza uma view com dados e um layout opcional.
     *
     * @param string $viewName O nome da view (ex: 'admin/roleta/index').
     * @param array $data Dados a serem passados para a view.
     * @param string|null $layoutName O nome do layout (ex: 'layouts/admin').
     */
    public static function render($viewName, $data = [], $layoutName = null)
    {
        // Extrai os dados para que as variáveis fiquem disponíveis na view
        extract($data);

        // Caminho completo para a view
        $viewPath = __DIR__ . '/../views/' . str_replace('.', '/', $viewName) . '.php';

        if (!file_exists($viewPath)) {
            die("Erro: View '$viewName' não encontrada em $viewPath");
        }

        // Inicia o buffer de saída para capturar o conteúdo da view
        ob_start();
        require $viewPath;
        $content = ob_get_clean(); // Captura o conteúdo da view

        if ($layoutName) {
            $layoutPath = __DIR__ . '/../views/' . str_replace('.', '/', $layoutName) . '.php';
            if (!file_exists($layoutPath)) {
                die("Erro: Layout '$layoutName' não encontrado em $layoutPath");
            }
            // Inclui o layout, que por sua vez incluirá $content
            require $layoutPath;
        } else {
            // Se não houver layout, apenas exibe o conteúdo da view
            echo $content;
        }
    }
}
