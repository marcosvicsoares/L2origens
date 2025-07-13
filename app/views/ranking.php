<h2>Ranking de Jogadores</h2>
<table>
    <thead>
        <tr>
            <th>Nome</th>
            <th>Nível</th>
            <th>PvP</th>
            <th>PK</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($players as $player): ?>
            <tr>
                <td><?= htmlspecialchars($player['char_name']) ?></td>
                <td><?= $player['level'] ?></td>
                <td><?= $player['pvpkills'] ?></td>
                <td><?= $player['pkkills'] ?></td>
                <td><?= $player['online'] ? 'Online' : 'Offline' ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
