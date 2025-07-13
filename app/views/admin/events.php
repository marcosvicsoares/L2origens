<h2>Criar Novo Evento</h2>
<form method="POST" action="/admin/events/create">
    <label>Título:</label><br>
    <input type="text" name="title" required><br><br>

    <label>Descrição:</label><br>
    <textarea name="description" rows="4" required></textarea><br><br>

    <label>Início:</label><br>
    <input type="datetime-local" name="starts_at" required><br><br>

    <label>Fim:</label><br>
    <input type="datetime-local" name="ends_at" required><br><br>

    <button type="submit">Criar Evento</button>
</form>

<h2>Eventos Criados</h2>
<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%; background: #222;">
    <thead>
        <tr style="background:#333;">
            <th>ID</th>
            <th>Título</th>
            <th>Início</th>
            <th>Fim</th>
            <th>Ativo</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($events as $event): ?>
        <tr>
            <td><?= $event['id'] ?></td>
            <td><?= htmlspecialchars($event['title']) ?></td>
            <td><?= $event['starts_at'] ?></td>
            <td><?= $event['ends_at'] ?></td>
            <td><?= $event['is_active'] ? 'Sim' : 'Não' ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
