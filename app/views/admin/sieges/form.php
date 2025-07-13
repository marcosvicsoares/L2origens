<?php
// A variável $siege é passada do controlador. Será null para criação e um array para edição.
/** @var array|null $siege */
/** @var string $pageTitle */

$isEditing = !empty($siege);
$formAction = $isEditing ? '/admin/sieges/edit/' . htmlspecialchars($siege['id']) : '/admin/sieges/create';
?>

<h2 class="text-2xl font-bold mb-4"><?php echo htmlspecialchars($pageTitle); ?></h2>

<?php if (isset($_GET['error'])): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <?php if ($_GET['error'] === 'invalid_data') echo 'Por favor, preencha todos os campos obrigatórios.'; ?>
        <?php if ($_GET['error'] === 'db_error') echo 'Ocorreu um erro ao salvar a siege no banco de dados.'; ?>
    </div>
<?php endif; ?>

<div class="bg-white p-6 rounded-lg shadow-lg">
    <form action="<?php echo $formAction; ?>" method="POST">
        <div class="mb-4">
            <label for="nome" class="block text-gray-700 text-sm font-bold mb-2">Nome da Siege:</label>
            <input type="text" id="nome" name="nome" value="<?php echo $isEditing ? htmlspecialchars($siege['nome']) : ''; ?>"
                   class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>

        <div class="mb-4">
            <label for="localizacao" class="block text-gray-700 text-sm font-bold mb-2">Localização:</label>
            <input type="text" id="localizacao" name="localizacao" value="<?php echo $isEditing ? htmlspecialchars($siege['localizacao']) : ''; ?>"
                   class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>

        <div class="mb-4">
            <label for="data_inicio" class="block text-gray-700 text-sm font-bold mb-2">Data e Hora de Início:</label>
            <input type="datetime-local" id="data_inicio" name="data_inicio" value="<?php echo $isEditing ? date('Y-m-d\TH:i', strtotime($siege['data_inicio'])) : ''; ?>"
                   class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>

        <div class="mb-4">
            <label for="data_fim" class="block text-gray-700 text-sm font-bold mb-2">Data e Hora de Fim:</label>
            <input type="datetime-local" id="data_fim" name="data_fim" value="<?php echo $isEditing ? date('Y-m-d\TH:i', strtotime($siege['data_fim'])) : ''; ?>"
                   class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>

        <div class="mb-4">
            <label for="recompensas" class="block text-gray-700 text-sm font-bold mb-2">Recompensas (JSON ou Texto):</label>
            <textarea id="recompensas" name="recompensas" rows="3"
                      class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"><?php echo $isEditing ? htmlspecialchars($siege['recompensas']) : ''; ?></textarea>
            <p class="text-xs text-gray-500 mt-1">Ex: {"item_id": 123, "quantidade": 10}</p>
        </div>

        <div class="mb-4">
            <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status:</label>
            <select id="status" name="status"
                    class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                <option value="scheduled" <?php echo ($isEditing && $siege['status'] === 'scheduled') ? 'selected' : ''; ?>>Agendada</option>
                <option value="active" <?php echo ($isEditing && $siege['status'] === 'active') ? 'selected' : ''; ?>>Ativa</option>
                <option value="finished" <?php echo ($isEditing && $siege['status'] === 'finished') ? 'selected' : ''; ?>>Finalizada</option>
                <option value="cancelled" <?php echo ($isEditing && $siege['status'] === 'cancelled') ? 'selected' : ''; ?>>Cancelada</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="min_players" class="block text-gray-700 text-sm font-bold mb-2">Mínimo de Jogadores:</label>
            <input type="number" id="min_players" name="min_players" value="<?php echo $isEditing ? htmlspecialchars($siege['min_players']) : ''; ?>"
                   class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" min="0">
        </div>

        <div class="mb-6">
            <label for="max_players" class="block text-gray-700 text-sm font-bold mb-2">Máximo de Jogadores:</label>
            <input type="number" id="max_players" name="max_players" value="<?php echo $isEditing ? htmlspecialchars($siege['max_players']) : ''; ?>"
                   class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" min="0">
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out">
                <?php echo $isEditing ? 'Atualizar Siege' : 'Agendar Siege'; ?>
            </button>
            <a href="/admin/sieges" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                Cancelar
            </a>
        </div>
    </form>
</div>
