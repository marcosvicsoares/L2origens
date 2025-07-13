<h2>Logs Administrativos</h2>

<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%; background: #222;">
    <thead>
        <tr style="background:#333;">
            <th>Admin</th>
            <th>Ação</th>
            <th>Data</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($logs as $log): ?>
        <tr>
            <td><?= htmlspecialchars($log['admin_login']) ?></td>
            <td><?= htmlspecialchars($log['action']) ?></td>
            <td><?= $log['created_at'] ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
