<?php
// A variável $item é passada do controlador. Será null para criação e um array para edição.
/** @var array|null $item */
/** @var string $pageTitle */

$isEditing = !empty($item);
$formAction = $isEditing ? '/admin/roleta/edit/' . htmlspecialchars($item['id']) : '/admin/roleta/create';
?>

<h2 class="text-2xl font-bold mb-4"><?php echo htmlspecialchars($pageTitle); ?></h2>

<?php if (isset($_GET['error'])): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <?php if ($_GET['error'] === 'invalid_data') echo 'Por favor, preencha todos os campos obrigatórios e verifique a probabilidade.'; ?>
        <?php if ($_GET['error'] === 'db_error') echo 'Ocorreu um erro ao salvar o item no banco de dados.'; ?>
    </div>
<?php endif; ?>

<div class="bg-white p-6 rounded-lg shadow-lg">
    <form action="<?php echo $formAction; ?>" method="POST">
        <div class="mb-4">
            <label for="nome" class="block text-gray-700 text-sm font-bold mb-2">Nome do Item:</label>
            <input type="text" id="nome" name="nome" value="<?php echo $isEditing ? htmlspecialchars($item['nome']) : ''; ?>"
                   class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>

        <div class="mb-4">
            <label for="descricao" class="block text-gray-700 text-sm font-bold mb-2">Descrição:</label>
            <textarea id="descricao" name="descricao" rows="3"
                      class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"><?php echo $isEditing ? htmlspecialchars($item['descricao']) : ''; ?></textarea>
        </div>

        <div class="mb-4">
            <label for="probabilidade" class="block text-gray-700 text-sm font-bold mb-2">Probabilidade (%):</label>
            <input type="number" id="probabilidade" name="probabilidade" value="<?php echo $isEditing ? htmlspecialchars($item['probabilidade']) : ''; ?>"
                   class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" min="0" max="100" required>
        </div>

        <div class="mb-4">
            <label for="item_id" class="block text-gray-700 text-sm font-bold mb-2">ID do Item (no jogo):</label>
            <input type="number" id="item_id" name="item_id" value="<?php echo $isEditing ? htmlspecialchars($item['item_id']) : ''; ?>"
                   class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" min="0">
        </div>

        <div class="mb-4">
            <label for="quantidade" class="block text-gray-700 text-sm font-bold mb-2">Quantidade:</label>
            <input type="number" id="quantidade" name="quantidade" value="<?php echo $isEditing ? htmlspecialchars($item['quantidade']) : ''; ?>"
                   class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" min="1">
        </div>

        <div class="mb-6">
            <label for="imagem" class="block text-gray-700 text-sm font-bold mb-2">URL da Imagem:</label>
            <input type="url" id="imagem" name="imagem" value="<?php echo $isEditing ? htmlspecialchars($item['imagem']) : ''; ?>"
                   class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out">
                <?php echo $isEditing ? 'Atualizar Item' : 'Criar Item'; ?>
            </button>
            <a href="/admin/roleta" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                Cancelar
            </a>
        </div>
    </form>
</div>
