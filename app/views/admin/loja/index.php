<?php
// A variável $itensLoja é passada do controlador para esta view
/** @var array $itensLoja */
?>

<h2 class="text-2xl font-bold mb-4">Gerenciamento de Itens da Loja</h2>

<?php if (isset($_GET['success'])): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <?php if ($_GET['success'] === 'created') echo 'Item da loja criado com sucesso!'; ?>
        <?php if ($_GET['success'] === 'updated') echo 'Item da loja atualizado com sucesso!'; ?>
        <?php if ($_GET['success'] === 'deleted') echo 'Item da loja excluído com sucesso!'; ?>
    </div>
<?php endif; ?>

<?php if (isset($_GET['error'])): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <?php if ($_GET['error'] === 'invalid_data') echo 'Dados inválidos fornecidos.'; ?>
        <?php if ($_GET['error'] === 'db_error') echo 'Ocorreu um erro ao interagir com o banco de dados.'; ?>
        <?php if ($_GET['error'] === 'not_found') echo 'Item da loja não encontrado.'; ?>
    </div>
<?php endif; ?>

<div class="mb-6">
    <a href="/admin/loja/create" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out">
        Adicionar Novo Item
    </a>
</div>

<?php if (empty($itensLoja)): ?>
    <p class="text-gray-600">Nenhum item na loja encontrado.</p>
<?php else: ?>
    <div class="overflow-x-auto bg-white rounded-lg shadow-lg">
        <table class="min-w-full leading-normal">
            <thead>
                <tr>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider rounded-tl-lg">ID</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nome</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Preço</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Categoria</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Imagem</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider rounded-tr-lg">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($itensLoja as $item): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($item['id']); ?></td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($item['nome']); ?></td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($item['categoria']); ?></td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <span class="relative inline-block px-3 py-1 font-semibold leading-tight">
                                <span aria-hidden="true" class="absolute inset-0 <?php echo ($item['status'] === 'active' ? 'bg-green-200' : 'bg-red-200'); ?> opacity-50 rounded-full"></span>
                                <span class="relative text-<?php echo ($item['status'] === 'active' ? 'green' : 'red'); ?>-900"><?php echo htmlspecialchars(ucfirst($item['status'])); ?></span>
                            </span>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <?php if (!empty($item['imagem'])): ?>
                                <img src="<?php echo htmlspecialchars($item['imagem']); ?>" alt="); ?>]" class="w-10 h-10 object-cover rounded-full">
                            <?php else: ?>
                                N/A
                            <?php endif; ?>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <a href="/admin/loja/edit/<?php echo htmlspecialchars($item['id']); ?>" class="text-blue-600 hover:text-blue-900 mr-3">Editar</a>
                            <a href="/admin/loja/delete/<?php echo htmlspecialchars($item['id']); ?>" class="text-red-600 hover:text-red-900" onclick="return confirm('Tem certeza que deseja excluir este item da loja?');">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
