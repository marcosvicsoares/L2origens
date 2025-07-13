<?php
namespace App\Controllers;

use App\Middleware\AdminMiddleware;
use App\Core\DB;
use App\Core\View; // Importa a classe View

class AdminEventsController
{
    public static function index()
    {
        AdminMiddleware::check();
        $events = DB::select("SELECT * FROM events ORDER BY starts_at DESC");

        // Prepara os dados para a view
        $data = [
            'pageTitle' => 'Gerenciar Eventos',
            'events' => $events,
        ];

        // Renderiza a view 'admin/events' usando o layout 'layout/admin'
        View::render('admin/events', $data, 'layout/admin');
    }

    public static function create()
    {
        AdminMiddleware::check();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $description = $_POST['description'] ?? '';
            $starts_at = $_POST['starts_at'] ?? '';
            $ends_at = $_POST['ends_at'] ?? '';

            // Validação básica para evitar erros de banco de dados
            if (empty($title) || empty($starts_at) || empty($ends_at)) {
                // Você pode armazenar uma mensagem de erro na sessão e redirecionar de volta
                $_SESSION['error_message'] = "Título, data de início e data de fim são obrigatórios.";
                header("Location: /admin/events/create_form"); // Assumindo que você tem um formulário de criação
                exit;
            }

            // Inserção do novo evento
            // Aqui estamos usando DB::execute, que é o método genérico para INSERT/UPDATE/DELETE.
            // Se você tiver um método DB::insert() específico, pode usá-lo.
            DB::execute("INSERT INTO events (title, description, starts_at, ends_at, is_active) VALUES (?, ?, ?, ?, 1)", [
                $title, $description, $starts_at, $ends_at
            ]);
			
			// Inserir log da ação administrativa:
            DB::execute("INSERT INTO admin_logs (admin_login, action) VALUES (?, ?)", [
                $_SESSION['user']['login'], 'Criou novo evento: ' . $title
            ]);
        
            header("Location: /admin/events");
            exit;
        }
        // Se a requisição não for POST, você pode renderizar um formulário de criação de evento aqui.
        // Exemplo:
        // View::render('admin/events_create_form', ['pageTitle' => 'Criar Novo Evento'], 'layout/admin');
    }
}
