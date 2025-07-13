<?php
// A variável $sieges é passada do controlador para esta view
/** @var array $sieges */
?>

<h2 class="text-2xl font-bold mb-4">Gerenciamento de Sieges</h2>

<?php if (isset($_GET['success'])): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <?php if ($_GET['success'] === 'created') echo 'Siege criada com sucesso!'; ?>
        <?php if ($_GET['success'] === 'updated') echo 'Siege atualizada com sucesso!'; ?>
        <?php if ($_GET['success'] === 'deleted') echo 'Siege excluída com sucesso!'; ?>
    </div>
<?php endif; ?>

<?php if (isset($_GET['error'])): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <?php if ($_GET['error'] === 'invalid_data') echo 'Dados inválidos fornecidos.'; ?>
        <?php if ($_GET['error'] === 'db_error') echo 'Ocorreu um erro ao interagir com o banco de dados.'; ?>
        <?php if ($_GET['error'] === 'not_found') echo 'Siege não encontrada.'; ?>
    </div>
<?php endif; ?>

<div class="mb-6">
    <a href="/admin/sieges/create" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out">
        Agendar Nova Siege
    </a>
</div>

<?php if (empty($sieges)): ?>
    <p class="text-gray-600">Nenhuma siege agendada.</p>
<?php else: ?>
    <div class="overflow-x-auto bg-white rounded-lg shadow-lg">
        <table class="min-w-full leading-normal">
            <thead>
                <tr>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider rounded-tl-lg">ID</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nome</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Início</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Fim</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Localização</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sieges as $siege): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($siege['id']); ?></td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($siege['nome']); ?></td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($siege['data_inicio']); ?></td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($siege['data_fim']); ?></td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($siege['localizacao']); ?></td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($siege['status']); ?></td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <a href="/admin/sieges/edit/<?php echo htmlspecialchars($siege['id']); ?>" class="text-blue-600 hover:text-blue-900 mr-3">Editar</a>
                            <a href="/admin/sieges/delete/<?php echo htmlspecialchars($siege['id']); ?>" class="text-red-600 hover:text-red-900" onclick="return confirm('Tem certeza que deseja excluir esta siege?');">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
