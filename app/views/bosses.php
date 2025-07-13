<h2>Status dos Bosses</h2>
<table>
    <thead>
        <tr>
            <th>Nome</th>
            <th>Nível</th>
            <th>Status</th>
            <th>Respawn</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($bosses as $boss): ?>
            <tr>
                <td><?= $boss['name'] ?></td>
                <td><?= $boss['level'] ?></td>
                <td><?= $boss['alive'] ? 'Vivo' : 'Morto' ?></td>
                <td><?= $boss['respawn_time'] ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
