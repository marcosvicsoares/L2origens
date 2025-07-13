<?php
    // A variável $battlePasses está disponível aqui, vinda do Controller
?>

<h2>Gerenciar Battle Pass</h2>
<p>Aqui você pode criar, editar e ativar os passes de batalha.</p>

<a href="/admin/battlepass/create">
    <button>Criar Novo Battle Pass</button>
</a>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Status</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($battlePasses as $bp): ?>
            <tr>
                <td><?php echo htmlspecialchars($bp['id']); ?></td>
                <td><?php echo htmlspecialchars($bp['nome']); ?></td>
                <td><?php echo $bp['ativo'] ? 'Ativo' : 'Inativo'; ?></td>
                <td>
                    <a href="/admin/battlepass/edit/<?php echo $bp['id']; ?>">Editar</a> | 
                    <a href="/admin/battlepass/delete/<?php echo $bp['id']; ?>">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>