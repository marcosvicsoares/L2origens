<?php
namespace App\Controllers;

use App\Core\View; // Importa a classe View

class HomeController
{
    /**
     * Exibe a página inicial do site.
     * Este método é chamado quando a rota '/' ou '/home' é acessada.
     *
     * @return void
     */
    public static function index()
    {
        // Prepara os dados que serão passados para a view.
        // Por exemplo, você pode buscar notícias, status do servidor, etc.
        $data = [
            'pageTitle' => 'Página Principal - tplbox.store', // Título da página
            'welcomeMessage' => 'Bem-vindo ao nosso servidor de Lineage II!', // Mensagem de boas-vindas
            // Adicione aqui quaisquer outros dados que sua página inicial precise.
            // Ex: 'latestNews' => \App\Models\News::getLatest(3),
            // 'serverStatus' => \App\Models\Server::getStatus(),
        ];

        // Renderiza a view 'home/index' usando o layout principal 'layout/main'.
        // O arquivo da view deve estar em C:\laragon\www\app\views\home\index.php
        // O layout deve estar em C:\laragon\www\app\views\layout\main.php
        View::render('home/index', $data, 'layout/main');
    }

    // Você pode adicionar outros métodos a este controlador se tiver mais funcionalidades para a página inicial.
}
