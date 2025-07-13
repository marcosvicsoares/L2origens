<h2>Votos Recentes</h2>

<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%; background: #222;">
    <thead>
        <tr style="background:#333;">
            <th>ID</th>
            <th>Conta</th>
            <th>IP</th>
            <th>Site</th>
            <th>Data</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($votos as $voto): ?>
        <tr>
            <td><?= $voto['id'] ?></td>
            <td><?= htmlspecialchars($voto['account']) ?></td>
            <td><?= $voto['ip_address'] ?></td>
            <td><?= $voto['site'] ?></td>
            <td><?= $voto['voted_at'] ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
