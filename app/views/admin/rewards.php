<h2>Enviar Recompensa</h2>
<form method="POST" action="/admin/rewards/send">
    <label>Personagem:</label>
    <input type="text" name="char_name" required>

    <label>ID do Item:</label>
    <input type="number" name="item_id" required>

    <label>Quantidade:</label>
    <input type="number" name="amount" required>

    <label>Encantamento:</label>
    <input type="number" name="enchant" value="0">

    <button type="submit">Enviar</button>
</form>
<h2>Recompensas Cadastradas</h2>

<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%; background: #222;">
    <thead>
        <tr style="background:#333;">
            <th>ID</th>
            <th>Item</th>
            <th>Quantidade</th>
            <th>Tipo</th>
            <th>Ativo</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($rewards as $reward): ?>
        <tr>
            <td><?= $reward['id'] ?></td>
            <td><?= htmlspecialchars($reward['item_name']) ?></td>
            <td><?= $reward['amount'] ?></td>
            <td><?= $reward['type'] ?></td>
            <td><?= $reward['is_active'] ? 'Sim' : 'Não' ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

